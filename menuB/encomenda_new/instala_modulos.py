import subprocess
import sys

print("Usando Python:", sys.executable)
print("Instalando módulos necessários para OCR...\n")

modulos = [
    "opencv-python",
    "pytesseract",
    "pillow",
    "numpy"
]

for modulo in modulos:
    print(f"Instalando {modulo}...")
    resultado = subprocess.run([sys.executable, "-m", "pip", "install", modulo])
    if resultado.returncode == 0:
        print(f"{modulo} instalado com sucesso!\n")
    else:
        print(f"❌ Falha ao instalar {modulo}.\n")

print("Fim do processo.")
