# Lista para almacenar las tareas
tareas = []

def mostrar_menu():
    print("\n--- GESTOR DE TAREAS ---")
    print("1. Agregar tarea")
    print("2. Ver tareas")
    print("3. Marcar como completada")
    print("4. Salir")
    def agregar_tarea():
    nombre = input("Escribe la tarea: ")
    # Creamos un pequeño objeto (diccionario) para la tarea
    nueva_tarea = {"nombre": nombre, "completada": False}
    tareas.append(nueva_tarea)
    print("¡Tarea agregada con éxito!")
    def ver_tareas():
    if not tareas:
        print("La lista está vacía.")
    else:
        for i, tarea in enumerate(tareas):
            # Usamos un operador ternario para poner un check si está lista
            estado = "✅" if tarea["completada"] else "❌"
            print(f"{i + 1}. {tarea['nombre']} [{estado}]")

def completar_tarea():
    ver_tareas()
    try:
        indice = int(input("Número de tarea a completar: ")) - 1
        tareas[indice]["completada"] = True
        print("¡Tarea actualizada!")
    except:
        print("Número no válido.")
        def ejecutar_programa():
    while True:
        mostrar_menu()
        opcion = input("Selecciona una opción: ")
        
        if opcion == "1":
            agregar_tarea()
        elif opcion == "2":
            ver_tareas()
        elif opcion == "3":
            completar_tarea()
        elif opcion == "4":
            print("Saliendo del programa...")
            break
        else:
            print("Opción no válida, intenta de nuevo.")

# Iniciar el programa
if __name__ == "__main__":
    ejecutar_programa();