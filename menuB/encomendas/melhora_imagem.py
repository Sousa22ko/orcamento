import cv2
import pytesseract

# Carrega a imagem
#imagem = cv2.imread('/uploads/b.jpg')
#import cv2

imagem = cv2.imread('C:/wamp64/www/menubootstrap/encomendas/uploads/b.jpg')


# Converte para tons de cinza
cinza = cv2.cvtColor(imagem, cv2.COLOR_BGR2GRAY)

# Binarização adaptativa (ajuda com iluminação irregular)
binarizada = cv2.adaptiveThreshold(cinza, 255, 
    cv2.ADAPTIVE_THRESH_GAUSSIAN_C, 
    cv2.THRESH_BINARY, 31, 2)

# Opcional: aumentar nitidez
binarizada = cv2.resize(binarizada, None, fx=2, fy=2, interpolation=cv2.INTER_CUBIC)
cv2.imwrite("imagem_processada.jpg", binarizada)

# Executa OCR
texto = pytesseract.image_to_string(binarizada, lang='por')
print(texto)
