from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
import time

# Configuración del navegador (headless=False para que veas el captcha)
chrome_options = Options()
# chrome_options.add_argument("--headless") # Descomentar para producción

# Asegúrate de tener el path de tu chromedriver
driver = webdriver.Chrome(options=chrome_options)

def consultar_sunat_directo(ruc):
    url = "https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp"
    driver.get(url)
    
    try:
        # 1. Localizar el campo de RUC
        campo_ruc = driver.find_element(By.ID, "txtRuc")
        campo_ruc.send_keys(ruc)
        
        print("Por favor, resuelve el captcha en la ventana del navegador.")
        # Esperamos a que el usuario resuelva el captcha y presione buscar
        # En una automatización real, aquí se usaría un servicio como 2Captcha
        
        input("Presiona Enter aquí cuando la página haya cargado los resultados...")
        
        # 2. Extraer datos (esto depende de los IDs actuales de SUNAT)
        razon_social = driver.find_element(By.XPATH, "//h4[contains(text(), 'Número de RUC')]").text
        print(f"Resultado: {razon_social}")
        
    except Exception as e:
        print(f"Error: {e}")
    finally:
        driver.quit()

consultar_sunat_directo("1076921609")