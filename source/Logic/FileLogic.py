import sys
import csv
import datetime
import time

def SaveToFile(homerseklet, paratartalom):
    
    try:
        ido = str(datetime.datetime.now())
        ido = ido[:-7]
        dir = "//home//pi//Idojaras/"
        f = open(dir+"database.csv" , 'at')
        w = csv.writer(f, delimiter=';')
        w.writerow(("RP03_01", ido, "{0:0.1f}".format(homerseklet) , "{0:0.1f}".format( paratartalom)))
    except:
        print('Error')
    finally:
        f.close()
 
