import importlib
import sys

print("📦 Verificando dependências do ambiente Python")
print("Python executado:", sys.executable)
print("Versão:", sys.version)
print("=" * 50)

dependencias = {
    "pytesseract": None,
    "cv2": "opencv-python",
    "PIL": "pillow",
    "numpy": None
}

for modulo, pacote in dependencias.items():
    try:
        lib = importlib.import_module(modulo)
        versao = getattr(lib, '__version__', 'desconhecida')
        print(f"✅ {modulo} está instalado. Versão: {versao}")
    except ImportError:
        nome_instalacao = pacote if pacote else modulo
        print(f"❌ {modulo} NÃO está instalado. Use: pip install {nome_instalacao}")

print("=" * 50)
print("🧪 Fim da verificação.")
