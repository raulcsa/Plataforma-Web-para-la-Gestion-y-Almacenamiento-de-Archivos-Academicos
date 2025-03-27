## **1. Introducción**  
El proyecto busca desarrollar una aplicación web que permita a los usuarios almacenar, organizar y compartir documentos académicos de manera eficiente. El sistema proporcionará una interfaz web amigable, integración segura de archivos mediante FTP y un backend robusto basado en tecnologías como PHP y Apache. Asimismo, se utilizará Docker para la gestión de contenedores y se desplegará el proyecto en un servidor VPS.

## **2. Objetivo General**  
Desarrollar una aplicación web que permita a los usuarios gestionar archivos académicos, ofreciendo funcionalidades como carga de documentos, categorización, búsqueda avanzada y descarga.

## **3. Objetivos Específicos**  
- Permitir la subida y almacenamiento de documentos mediante protocolo FTP.  
- Organizar los documentos en categorías y permitir su búsqueda mediante filtros.  
- Implementar un sistema de autenticación de usuarios seguro.  
- Establecer un entorno de desarrollo seguro con SSL/TLS.  
- Integrar un sistema de backup automatizado de documentos.  
- Contener todo el entorno del proyecto en contenedores Docker para facilitar su despliegue y mantenimiento.  
- Crear un archivo **Docker Compose** que gestione la aplicación web, la base de datos y el servidor FTP.  
- Configurar la base de datos y el servidor FTP como servicios Docker independientes y vinculados al backend.  
- Diseñar un sistema de despliegue automático hacia un servidor **VPS**, optimizando su configuración.  
- Implementar un sistema de monitoreo para los servicios críticos del entorno (base de datos, FTP, web) utilizando herramientas compatibles con Docker.

## **4. Justificación**  
En un entorno educativo, contar con una plataforma accesible y centralizada para la gestión de documentos es esencial para mejorar la eficiencia del trabajo colaborativo y académico. La integración de contenedores mediante Docker y el despliegue en un VPS garantizará la portabilidad y escalabilidad del proyecto, adaptándose a las necesidades cambiantes de los usuarios.

## **5. Esquema**

![esquemarquitectura](https://github.com/user-attachments/assets/6139ca5c-465e-4a20-b649-97513631ebec)
