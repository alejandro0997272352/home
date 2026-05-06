import customtkinter as ctk
from PIL import Image, ImageFilter
import pygame
import time

class AppleMusicClone(ctk.CTk):
    def __init__(self):
        super().__init__()

        self.title("Python Music Player")
        self.geometry("1000x600")
        
        # 1. Configuración de Audio
        pygame.mixer.init()
        pygame.mixer.music.load("cancion.mp3") # Tu archivo aquí
        
        # 2. UI Layout
        self.grid_columnconfigure(0, weight=1)
        self.grid_columnconfigure(1, weight=1)
        
        # Lado Izquierdo: Portada y Controles
        self.left_frame = ctk.CTkFrame(self, fg_color="transparent")
        self.left_frame.grid(row=0, column=0, padx=40, pady=40, sticky="nsew")
        
        # Portada con bordes redondeados
        img = Image.open("imagen.jpg") # Tu imagen aquí
        self.cover_img = ctk.CTkImage(img, size=(350, 350))
        self.cover_label = ctk.CTkLabel(self.left_frame, image=self.cover_img, text="")
        self.cover_label.pack(pady=20)
        
        self.title_label = ctk.CTkLabel(self.left_frame, text="Me seguirás buscando", font=("SF Pro Display", 24, "bold"))
        self.title_label.pack()
        
        self.play_btn = ctk.CTkButton(self.left_frame, text="▶ Play", command=self.play_music, fg_color="#fff", text_color="#000")
        self.play_btn.pack(pady=20)

        # Lado Derecho: Letras
        self.lyrics_frame = ctk.CTkScrollableFrame(self, fg_color="transparent")
        self.lyrics_frame.grid(row=0, column=1, padx=40, pady=40, sticky="nsew")
        
        self.lyrics_data = [
            (24, "Cuando pienses irte"),
            (27, "No me digas nada"),
            (31, "Que ya yo lo sé"),
            (36, "Que tú no me amabas")
        ]
        
        self.lyric_labels = []
        for time_sec, text in self.lyrics_data:
            lbl = ctk.CTkLabel(self.lyrics_frame, text=text, font=("SF Pro Display", 32, "bold"), text_color="gray")
            lbl.pack(pady=20, anchor="w")
            self.lyric_labels.append((time_sec, lbl))

    def play_music(self):
        pygame.mixer.music.play()
        self.update_lyrics()

    def update_lyrics(self):
        if pygame.mixer.music.get_busy():
            curr_time = pygame.mixer.music.get_pos() / 1000
            for t, lbl in self.lyric_labels:
                if curr_time >= t:
                    # Resetear colores
                    for _, l in self.lyric_labels: l.configure(text_color="gray")
                    # Resaltar activa
                    lbl.configure(text_color="white")
            
            self.after(500, self.update_lyrics)

if __name__ == "__main__":
    app = AppleMusicClone()
    app.mainloop()