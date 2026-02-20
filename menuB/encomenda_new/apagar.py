import pytesseract
from PIL import Image

pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

imagem = Image.open("uploads/b.jpg")
texto = pytesseract.image_to_string(imagem, lang="por")
print(texto)
