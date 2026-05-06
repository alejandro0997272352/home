import tkinter as tk
from tkinter import messagebox

def calcular_imc():
    nombre = entry_nombre.get()
    try:
        peso = float(entry_peso.get())
        altura = float(entry_altura.get())
        
        # Fórmula médica del IMC: peso / altura^2
        imc = peso / (altura ** 2)
        
        # Diagnóstico basado en rangos de salud
        if imc < 18.5:
            diagnostico = "Bajo peso"
            color = "#3498db" # Azul
        elif 18.5 <= imc < 24.9:
            diagnostico = "Peso normal (Saludable)"
            color = "#2ecc71" # Verde
        elif 25 <= imc < 29.9:
            diagnostico = "Sobrepeso"
            color = "#f1c40f" # Amarillo
        else:
            diagnostico = "Obesidad"
            color = "#e74c3c" # Rojo
            
        # Mostrar resultado
        resultado_txt = f"Paciente: {nombre}\nIMC: {imc:.2f}\nEstado: {diagnostico}"
        lbl_resultado.config(text=resultado_txt, fg=color)
        
    except ValueError:
        messagebox.showerror("Error de datos", "Por favor ingresa valores numéricos para peso y altura.")
    except ZeroDivisionError:
        messagebox.showerror("Error", "La altura no puede ser cero.")

# Configuración de la interfaz (GUI)
root = tk.Tk()
root.title("HealthCheck Pro - Enfermería")
root.geometry("400x450")
root.configure(bg="#f4f7f6")

# Título
tk.Label(root, text="SISTEMA DE EVALUACIÓN NUTRICIONAL", bg="#f4f7f6", font=("Arial", 12, "bold")).pack(pady=20)

# Campos de entrada
tk.Label(root, text="Nombre del Paciente:", bg="#f4f7f6").pack()
entry_nombre = tk.Entry(root, justify='center')
entry_nombre.pack(pady=5)

tk.Label(root, text="Peso (kg):", bg="#f4f7f6").pack()
entry_peso = tk.Entry(root, justify='center')
entry_peso.pack(pady=5)

tk.Label(root, text="Altura (metros - ej: 1.70):", bg="#f4f7f6").pack()
entry_altura = tk.Entry(root, justify='center')
entry_altura.pack(pady=5)

# Botón de cálculo
btn_calcular = tk.Button(root, text="CALCULAR DIAGNÓSTICO", command=calcular_imc, bg="#2c3e50", fg="white", font=("Arial", 10, "bold"), padx=10, pady=5)
btn_calcular.pack(pady=25)

# Etiqueta de resultado
lbl_resultado = tk.Label(root, text="", bg="#f4f7f6", font=("Arial", 12, "bold"), justify='left')
lbl_resultado.pack(pady=10)

root.mainloop()