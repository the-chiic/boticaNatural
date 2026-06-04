# 📘 Documentación Técnica de Flujo de Datos (TFG)
## Arquitectura Modelo-Vista-Controlador (MVC) en Botica Natural

Este documento explica de forma detallada y extensa el flujo de datos para la presentación del TFG. Cubre las secciones de **Mi Perfil**, **Clientes (Admin)** y **Promociones (Admin)** en la rama `developmentCambiosContraseña`.

---

## 🏛️ Conceptos Clave para la Defensa

Cuando te pregunten sobre la arquitectura del software, explica que sigues el patrón **MVC (Modelo-Vista-Controlador)**:
1. **La Ruta (Web/API):** Captura la petición HTTP (ej. `/perfil`) y delega el control a un método específico de un Controlador.
2. **El Controlador:** Contiene la lógica del negocio. Recibe los parámetros de la solicitud (`Request`), valida los datos, interactúa con el Modelo/Base de datos y decide qué Vista retornar (o devuelve una respuesta JSON).
3. **El Modelo / Query Builder (Base de Datos):** Abstrae la base de datos relacional. Eloquent ORM mapea las tablas como objetos de PHP (ej. `User`), mientras que el Query Builder (`DB::table`) se usa para consultas SQL directas optimizadas.
4. **La Vista (Blade / JSON):** Renderiza los datos finales del lado del cliente o devuelve estructuras JSON preparadas para consumo frontend.

---

## 👤 1. Flujo de Datos: Mi Perfil

### 📄 Archivos Involucrados
* **Controlador:** [ControladorPerfil.php](file:///c:/Users/Adrian/Documents/GitHub/boticaNatural/app/Http/Controllers/ControladorPerfil.php)
* **Modelos principales:** [User.php](file:///c:/Users/Adrian/Documents/GitHub/boticaNatural/app/Models/User.php), `orders` (tabla), `address` (tabla)

### 📌 Rutas y Métodos

#### A. Ver Perfil
* **Ruta:** `GET /perfil` &rarr; `ControladorPerfil@verPerfil`
* **Flujo de datos paso a paso:**
  1. El cliente solicita la URL `/perfil`.
  2. El middleware `auth` comprueba que el usuario está logueado. Si no, lo redirige.
  3. `ControladorPerfil::verPerfil()` captura el ID del usuario en sesión con `Auth::id()`.
  4. Realiza dos consultas directas a la base de datos usando el constructor de consultas de Laravel (`DB`):
     * Busca los registros de la tabla `orders` filtrando por el campo `user_id` y ordenándolos de manera descendente por `order_date` (`get()`).
     * Busca las direcciones asociadas al usuario en la tabla `address` filtrando por `user_id`.
  5. Retorna la vista `profile.index` empaquetando ambas colecciones usando `compact('pedidos', 'direcciones')`.
* **Esquema de datos:**
  ```
  [Usuario HTTP GET] ➔ [Router: /perfil] ➔ [ControladorPerfil::verPerfil]
                                                │
       ┌────────────────────────────────────────┴────────────────────────────────────────┐
       ▼ (Query Builder)                                                                 ▼ (Query Builder)
  [Tabla: orders WHERE user_id]                                                     [Tabla: address WHERE user_id]
       │                                                                                 │
       └────────────────────────────────────────┬────────────────────────────────────────┘
                                                ▼
                                [Vista Blade: profile.index]
  ```

#### B. Actualizar Datos de Perfil
* **Ruta:** `PUT /perfil/actualizar` &rarr; `ControladorPerfil@actualizarDatos`
* **Flujo de datos paso a paso:**
  1. El formulario envía datos mediante método HTTP `POST` con la directiva `@method('PUT')` en Blade para simular una petición `PUT`.
  2. `actualizarDatos(Request $solicitud)` valida los datos de entrada en el servidor:
     * `name` (Requerido, cadena, máx. 100 caracteres).
     * `phone` (Opcional/nullable, cadena, máx. 30 caracteres).
  3. Recupera la instancia del modelo Eloquent de la sesión mediante `Auth::user()`.
  4. Ejecuta `$usuario->update([...])` de Eloquent, que internamente lanza una sentencia SQL `UPDATE user SET name = ?, phone = ? WHERE id = ?`.
  5. Retorna una redirección hacia atrás (`back()`) inyectando un mensaje de sesión flash `success`.

#### C. Añadir Dirección
* **Ruta:** `POST /perfil/direccion` &rarr; `ControladorPerfil@agregarDireccion`
* **Flujo de datos paso a paso:**
  1. El usuario envía el formulario con sus datos postales.
  2. El controlador valida los campos indispensables (`address`, `city`, `post_code`, `country`) y los opcionales.
  3. El controlador obtiene el ID del usuario actual mediante `Auth::id()`.
  4. Inserta directamente un nuevo registro en la tabla `address` usando `DB::table('address')->insert([...])`.
     * *Detalle de diseño:* Si el campo `name_destination` no se envía, por defecto inserta el nombre del usuario autenticado (`Auth::user()->name`).
  5. Retorna hacia atrás redirigiendo al cliente con confirmación de éxito.

#### D. Eliminar Dirección
* **Ruta:** `DELETE /perfil/direccion/{id}` &rarr; `ControladorPerfil@eliminarDireccion`
* **Flujo de datos paso a paso:**
  1. Recibe por parámetro `$id` la clave primaria de la dirección que el usuario desea borrar.
  2. Por motivos de **seguridad**, la consulta incluye la restricción `user_id`:
     ```php
     DB::table('address')->where('id', $id)->where('user_id', Auth::id())->delete();
     ```
     *(Esto impide que un usuario malintencionado edite el HTML de la petición y borre una dirección que pertenece a otro usuario)*.
  3. Redirecciona hacia atrás tras la eliminación física del registro.

#### E. Detalles de un Pedido en Específico
* **Ruta:** `GET /perfil/pedido/{id}/detalles` &rarr; `ControladorPerfil@detallesPedido`
* **Flujo de datos paso a paso:**
  1. Utilizado para cargar los detalles del pedido de forma dinámica (típicamente a través de un modal con llamadas AJAX).
  2. Busca el pedido en la tabla `orders` filtrando por `$id` y asegurándose de que pertenezca al usuario autenticado (`user_id`).
  3. Si no existe, devuelve una respuesta JSON indicando que no está autorizado o no se encontró (código HTTP `403 Forbidden`).
  4. Si existe, hace una consulta JOIN de la tabla `order_line` con `product` para obtener las unidades, el precio cobrado y el nombre real del producto en esa transacción:
     ```sql
     SELECT order_line.*, product.name as product_name 
     FROM order_line 
     INNER JOIN product ON order_line.product_id = product.id 
     WHERE order_line.order_id = ?
     ```
  5. Adicionalmente, el controlador itera sobre las líneas y consulta el modelo [Product](file:///c:/Users/Adrian/Documents/GitHub/boticaNatural/app/Models/Product.php) (`Product::find($linea->product_id)`) para recuperar el enlace de su imagen de cabecera (`image_url`), enriqueciendo la colección devuelta.
  6. Envía una respuesta HTTP estructurada en formato JSON al cliente frontend con los datos generales del pedido (`order`) y las líneas asociadas (`lines`).

---

## 👥 2. Flujo de Datos: Clientes (Panel de Administración)

### 📄 Archivos Involucrados
* **Controlador:** [AdminController.php](file:///c:/Users/Adrian/Documents/GitHub/boticaNatural/app/Http/Controllers/AdminController.php)
* **Modelos principales:** [User.php](file:///c:/Users/Adrian/Documents/GitHub/boticaNatural/app/Models/User.php) (tabla `user` en BBDD), `orders` (tabla)

### 📌 Rutas y Métodos

#### A. Directorio de Clientes
* **Ruta:** `GET /admin/clientes` &rarr; `AdminController@clientes`
* **Flujo de datos paso a paso:**
  1. El administrador solicita el listado de clientes.
  2. El controlador realiza una consulta compleja utilizando el Query Builder sobre la tabla `user` y uniéndola con la tabla `orders`:
     ```php
     DB::table('user')
         ->leftJoin('orders', 'user.id', '=', 'orders.user_id')
         ->select('user.id', 'user.name', 'user.email', 'user.phone', 'user.created_at', DB::raw('COUNT(orders.id) as orders_count'))
         ->groupBy('user.id', 'user.name', 'user.email', 'user.phone', 'user.created_at')
         ->orderBy('orders_count', 'desc')
         ->get();
     ```
     * **¿Por qué `leftJoin`?** Para asegurar que si un cliente se ha registrado pero aún **no ha realizado ninguna compra**, siga apareciendo en el listado con un total de pedidos igual a 0.
     * **¿Por qué `COUNT(orders.id)`?** Para calcular de forma agregada el número total de compras de cada cliente.
     * **¿Por qué `groupBy`?** Obligatorio por el estándar SQL cuando se utilizan funciones de agregación (como `COUNT`) combinadas con columnas normales.
  3. Retorna la vista `admin.customers` enviando el listado `$customers`.

#### B. Obtener Detalles de Cliente por AJAX
* **Ruta:** `GET /admin/clientes/{id}/detalles` &rarr; `AdminController@detallesCliente`
* **Flujo de datos paso a paso:**
  1. El panel de administración realiza una petición asíncrona para consultar la ficha completa del usuario.
  2. Obtiene el registro del usuario mediante Eloquent: `User::findOrFail($id)`. Si el ID no existe en la base de datos, Laravel lanza automáticamente una excepción `ModelNotFoundException` y devuelve una respuesta HTTP `404 Not Found`.
  3. Obtiene todas las direcciones de envío registradas por este usuario específico de la tabla `address`, ordenándolas por su ID de manera descendente.
  4. Obtiene el histórico completo de pedidos de la tabla `orders` para este usuario.
  5. Retorna toda la información estructurada en un objeto JSON único con tres claves (`customer`, `addresses` y `orders`).
* **Esquema de datos:**
  ```
  [Administrador] ➔ [Petición AJAX a /admin/clientes/{id}/detalles]
                             │
                             ▼
              [AdminController::detallesCliente]
                             │
        ┌────────────────────┼────────────────────┐
        ▼                    ▼                    ▼
  [Modelo User]       [Tabla: address]     [Tabla: orders]
     (Eloquent)          (Query Builder)      (Query Builder)
        │                    │                    │
        └────────────────────┬────────────────────┘
                             ▼
                    [JSON Response (200)]
  ```

---

## 🏷️ 3. Flujo de Datos: Promociones (Panel de Administración)

### 📄 Archivos Involucrados
* **Controlador:** [AdminController.php](file:///c:/Users/Adrian/Documents/GitHub/boticaNatural/app/Http/Controllers/AdminController.php)
* **Modelos principales:** [Promotion.php](file:///c:/Users/Adrian/Documents/GitHub/boticaNatural/app/Models/Promotion.php), [Product.php](file:///c:/Users/Adrian/Documents/GitHub/boticaNatural/app/Models/Product.php)

### 📌 Rutas y Métodos

#### A. Listado de Promociones (Cupones)
* **Ruta:** `GET /admin/promociones` &rarr; `AdminController@promociones`
* **Flujo de datos paso a paso:**
  1. El controlador recupera todas las promociones del modelo Eloquent [Promotion](file:///c:/Users/Adrian/Documents/GitHub/boticaNatural/app/Models/Promotion.php) ordenadas descendentemente por su ID (`orderBy('id', 'desc')->get()`).
  2. Devuelve la vista `admin.promotions` inyectando la colección `$promotions`.

#### B. Guardar Nueva Promoción
* **Ruta:** `POST /admin/promociones` &rarr; `AdminController@guardarPromocion`
* **Flujo de datos paso a paso:**
  1. El administrador rellena el formulario de creación del cupón.
  2. El controlador ejecuta `$request->validate()` aplicando reglas de integridad:
     * `code`: Debe ser una cadena, máximo 50 caracteres y ser **único** en la tabla `promotion`.
     * `discount`: Debe ser numérico, mínimo 0% y máximo 100%.
     * `starts_at` / `ends_at`: Fechas. El fin de la promoción debe ser una fecha posterior o igual al inicio (`after_or_equal:starts_at`).
  3. Crea y persiste el registro en base de datos usando `Promotion::create([...])`.
     * *Detalle:* Aplica `strtoupper($request->code)` para almacenar siempre el código de descuento en mayúsculas (ej. `DESCUENTO10`), facilitando la comparación posterior en el carrito de compras.
  4. Redirecciona de vuelta con mensaje flash de confirmación exitosa.

#### C. Actualizar Promoción
* **Ruta:** `POST /admin/promociones/{id}` &rarr; `AdminController@actualizarPromocion`
* **Flujo de datos paso a paso:**
  1. Recibe la petición HTTP POST con el ID de la promoción a modificar y los campos validados.
  2. Encuentra la promoción mediante Eloquent: `Promotion::findOrFail($id)`.
  3. Utiliza la técnica de hidratación parcial y validación de suciedad (`isDirty`):
     * Carga los datos en el modelo de forma temporal con `fill([...])`.
     * Comprueba si el modelo ha sufrido modificaciones respecto a la base de datos con `$promotion->isDirty()`.
     * Si el modelo está "sucio" (tiene cambios), ejecuta `update([...])` para escribir físicamente las modificaciones en la base de datos.
  4. Redirecciona de vuelta con confirmación de éxito.

#### D. Eliminar Promoción
* **Ruta:** `POST /admin/promociones/{id}/eliminar` &rarr; `AdminController@eliminarPromocion`
* **Flujo de datos paso a paso:**
  1. Busca la promoción por su ID con `findOrFail($id)`.
  2. **Desvinculación:** Antes de borrar la promoción, realiza un paso de mantenimiento de base de datos:
     ```php
     DB::table('product')->where('promotion_id', $id)->update(['promotion_id' => null]);
     ```
     *(Esto desvincula a todos los productos que estuvieran asociados a ese descuento, evitando errores de clave foránea o datos corruptos)*.
  3. Finalmente, borra el registro de la promoción llamando a `$promotion->delete()`.
  4. Redirecciona de vuelta al listado.

#### E. Alternar Activo/Inactivo (Método AJAX Toggle)
* **Ruta:** `PUT /admin/promociones/{id}/toggle` &rarr; `AdminController@togglePromocion`
* **Flujo de datos paso a paso:**
  1. Diseñado para interactuar con botones tipo "switch" en la interfaz de usuario en tiempo real sin recargar la página.
  2. Busca la promoción mediante Eloquent.
  3. Calcula el nuevo estado lógico: si está activo (`is_active = 1`) lo pasa a inactivo (`0`) y viceversa.
  4. Usa `fill()` y evalúa si ha cambiado con `isDirty('is_active')`.
  5. Ejecuta `update()` en base de datos si hay cambios detectados.
  6. Devuelve una respuesta JSON detallada con los campos actualizados (`success: true`, `is_active`, `discount`, etc.).

#### F. Alternar Mostrar en la Web (Método AJAX Toggle Web)
* **Ruta:** `PUT /admin/promociones/{id}/toggle-web` &rarr; `AdminController@togglePromocionWeb`
* **Flujo de datos paso a paso:**
  1. Sigue la misma lógica asíncrona que el toggle de activación, pero afectando a la columna `show_on_web`.
  2. Determina si la promoción debe mostrarse en la página principal visible para clientes o si permanece oculta para uso exclusivo de cupones privados.
  3. Evalúa cambios con `isDirty('show_on_web')`, los guarda en base de datos y retorna una estructura JSON detallada de éxito para actualizar el DOM dinámicamente mediante Javascript.

---

## 🌟 Resumen de Respuestas Rápidas para el Tribunal

| Pregunta Típica | Respuesta Sugerida |
| :--- | :--- |
| **¿Cómo aseguras que un cliente no vea pedidos de otros?** | En `ControladorPerfil@detallesPedido` no solo filtramos por el `id` del pedido, sino que siempre añadimos la cláusula `where('user_id', Auth::id())` para garantizar que el registro pertenezca al usuario autenticado. |
| **¿Qué ocurre si intentas borrar una promoción vinculada a productos?** | En `AdminController@eliminarPromocion` primero ejecutamos un `UPDATE` en la tabla `product` para poner su `promotion_id` a `null`. Esto desvincula los productos de forma limpia y evita errores de integridad de base de datos antes de hacer el `delete()`. |
| **¿Qué ventaja tiene usar `leftJoin` en el listado de clientes?** | Si usáramos un `innerJoin`, los clientes recién registrados que no tengan pedidos no saldrían en el listado de administración. El `leftJoin` asegura que recuperemos todos los clientes (`user`) y nos da su recuento de pedidos (incluso si es `0`). |
| **¿Para qué sirve `isDirty()` en el controlador?** | Se usa en la actualización de promociones y stocks para comprobar si realmente el valor del modelo ha cambiado en comparación con lo que hay almacenado en base de datos. Si no hay cambios, evitamos realizar una consulta de actualización `UPDATE` innecesaria a la BBDD, mejorando el rendimiento. |
