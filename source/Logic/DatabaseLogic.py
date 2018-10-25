import sys
import mysql.connector as mariadb
def SaveToDatabase(station,temperature,humidity):
    try:
        print("Save to database...")
        mariadb_connection = mariadb.connect(user='user1',
                                        database='db1')
        cursor = mariadb_connection.cursor()
        try:
            cursor.execute("INSERT INTO mensuration (sender_id,mensuration_TS,temperature,humidity) VALUES (%s,now(),%s,%s)", (station,temperature,humidity))
        except mariadb.Error as error:
            print("Error: {}".format(error))
        mariadb_connection.commit()
        mariadb_connection.close()
        print(">>> OK!")
    except mariadb.Error as error:
        print("Error: {}".format(error))





