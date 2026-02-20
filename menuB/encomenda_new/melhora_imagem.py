# melhora_imagem.py
import cv2
import pytesseract
import numpy as np
import sys
import os

# ----- Ajuste o caminho do tesseract se necessário -----
# pytesseract.pytesseract.tesseract_cmd = r"C:\Program Files\Tesseract-OCR\tesseract.exe"

# Caminhos
IMG_IN = "uploads/imagem_recebida.jpg"
IMG_OUT = "uploads/imagem_tratada.png"
TXT_OUT = "uploads/resultado.txt"

# Carrega
img = cv2.imread(IMG_IN)
if img is None:
    print("Erro: não conseguiu carregar", IMG_IN)
    sys.exit(1)

# 1) converte para cinza
gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)

# 2) remover ruído (fastNlMeansDenoising preserva contornos)
den = cv2.fastNlMeansDenoising(gray, h=10, templateWindowSize=7, searchWindowSize=21)

# 3) CLAHE (melhora contraste local)
clahe = cv2.createCLAHE(clipLimit=2.0, tileGridSize=(8,8))
cl = clahe.apply(den)

# 4) leve blur para reduzir granulação residual
blur = cv2.GaussianBlur(cl, (3,3), 0)

# 5) Threshold (usar Otsu para escolher limiar automaticamente)
_, th = cv2.threshold(blur, 0, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)

# 6) operações morfológicas: abrir para remover pontos, depois dilatar para engrossar letras finas
kernel = cv2.getStructuringElement(cv2.MORPH_RECT, (2,2))
opened = cv2.morphologyEx(th, cv2.MORPH_OPEN, kernel, iterations=1)
morph = cv2.dilate(opened, kernel, iterations=1)

# 7) redimensiona para aumentar resolução aparente (Tesseract se dá melhor com texto maior)
scale = 2  # experimente 2 ou 3
resized = cv2.resize(morph, None, fx=scale, fy=scale, interpolation=cv2.INTER_CUBIC)

# 8) unsharp mask para nitidez (controlada)
gauss = cv2.GaussianBlur(resized, (0,0), 3)
sharpen = cv2.addWeighted(resized, 1.4, gauss, -0.4, 0)

# Salva imagem tratada para inspeção
cv2.imwrite(IMG_OUT, sharpen)

# ------- Função auxiliar para fazer OCR com várias configs -------
def ocr_test(image, configs):
    results = []
    for cfg in configs:
        try:
            txt = pytesseract.image_to_string(image, lang='por', config=cfg)
        except Exception as e:
            txt = f"[ERRO no pytesseract com cfg={cfg}] {e}"
        results.append((cfg, txt))
    return results

# Configs para testar (tente vários PSM)
configs = [
    "--oem 1 --psm 6",   # bloco uniforme de texto
    "--oem 1 --psm 4",   # várias colunas
    "--oem 1 --psm 3",   # automático (página inteira)
    "--oem 1 --psm 11"   # texto esparso
]

# Executa OCR
results = ocr_test(sharpen, configs)

# Salva resultados em resultado.txt
with open(TXT_OUT, "w", encoding="utf-8") as f:
    f.write(f"Imagem original: {IMG_IN}\nImagem processada: {IMG_OUT}\n\n")
    for cfg, txt in results:
        f.write("==== CONFIG: " + cfg + " ====\n")
        f.write(txt.strip() + "\n\n")

# Mostra resumo no stdout (útil ao chamar via PHP exec)
print("OK - processado. Veja", IMG_OUT, "e", TXT_OUT)
