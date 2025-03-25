
## ¿Qué es MVC?

**MVC** significa **Modelo-Vista-Controlador**, es un **patrón de diseño** que ayuda a estructurar el código de una aplicación web, separando claramente responsabilidades en tres partes. Esto facilita el desarrollo, mantenimiento y escalabilidad de las aplicaciones.


## Componentes Fundamentales del MVC

MVC se compone de **3 partes fundamentales**:

### 1. 📂 Modelo (*Model*)

El **Modelo** gestiona toda la lógica relacionada con los datos:

- Cómo se almacenan
- Cómo se recuperan
- Cómo se procesan

**Funciones del modelo**:

- Se comunica directamente con la base de datos.
- Realiza operaciones **CRUD** (*Create, Read, Update, Delete*).
- Valida la información.

---

### 2. 🖥️ Vista (*View*)

La **Vista** es la interfaz gráfica o visualización de los datos al usuario final:

- No contiene lógica compleja, solo presenta información.
- Recibe los datos desde el Controlador y los muestra al usuario mediante tecnologías web como HTML, CSS o JS.

---

### 3. ⚙️ Controlador (*Controller*)

El **Controlador** actúa como intermediario entre el Modelo y la Vista. Sus responsabilidades son:

- Recibir peticiones del usuario (**HTTP GET** o **POST**).
- Gestionar cómo responder a cada petición:
  - Solicitar datos al Modelo.
  - Enviar los datos obtenidos del Modelo hacia la Vista para presentarlos.

---

## Flujo MVC

El flujo de datos en una aplicación basada en MVC se puede visualizar claramente con el siguiente esquema:

~~~
Petición del usuario (Navegador)
            │
            ▼
 ┌───────────────────┐
 │    Controlador    │─── Solicita datos ──► ┌─────────┐
 └───────────────────┘                       │ Modelo  │
            │                                └─────────┘
            │                                   │ ▲
            ▼                                   ▼ │
 ┌───────────────────┐                       ┌─────────┐
 │       Vista       │◄───Entrega datos ─────┤ BBDD    │
 └───────────────────┘                       └─────────┘
            │
            ▼
Respuesta al usuario (HTML en navegador)

~~~
