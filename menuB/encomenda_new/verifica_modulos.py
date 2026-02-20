import sys
import importlib.util
import os

def checar_modulo(nome):
    return importlib.util.find_spec(nome) is not None

print("Python usado:", sys.executable)
print("Versao do Python:", sys.version)
print("Diretorio atual:", os.getcwd())

modulos = ['cv2', 'pytesseract', 'PIL', 'numpy']
print("\nVerificando modulos...\n")

for m in modulos:
    status = "OK" if checar_modulo(m) else "NaO INSTALADO"
    print(f"{m}: {status}")
