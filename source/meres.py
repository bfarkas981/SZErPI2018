import sys
import time
import Adafruit_DHT
#import pip
#pip.main(['install','mysql-connector-python-rf'])
import mysql.connector as mariadb
import Logic.TwitterLogic as tw
import Logic.DatabaseLogic as db
import Logic.DisplayLogic as di
import Logic.FileLogic as fl
print("Start app")



tw.SendMessage("Elindult az alkalmazás!")
station='station1'
humidity=-1
temperature=-1

try:
    di.ShowText('Meres','...')
    sensor = Adafruit_DHT.DHT22
    pin=22
    humidity, temperature = Adafruit_DHT.read_retry(sensor,pin)
    if humidity is not None and temperature is not None:
        print('Temp={0:0.1f}*C Humidity={1:0.1f}%'.format(temperature,humidity))
        di.ShowText('Adatmentes','adatbazisba')
        db.SaveToDatabase(station,temperature,humidity)
        time.sleep(1)
        di.ShowText('Adatmentes','fileba(csv)')
        fl.SaveToFile(temperature,humidity)
        time.sleep(1)
        di.ShowText('Homer.: {0:0.1f}*C'.format(temperature),'Parat.: {0:0.1f}%'.format(humidity))
    else:
        di.ShowText('Error 101','Szenzor hiba')
        print('Error 101')
except:
    print('Error 501')
    di.ShowText('Error 501','Ismeretlen hiba')









