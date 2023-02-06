# データベース用
# 使用するパッケージはMYSQLを使用するためのmysql-connector-python
import mysql.connector

class Database:
    def __init__(self,user="root",password="",host="localhost",db="test"):
        try:
            config = {
                "user":user,
                "password":password,
                "host":host,
                "database":db
            }

            self.cnx = mysql.connector.connect(**config)
            self.cnx.is_connected()
            self.cur = self.cnx.cursor() # SQLを実行させるための準備

        except(mysql.connector.errors.ProgrammingError) as e:
            print("Error Occured when DB Connected: " + str(e))
        # except Exception(e):
        #     print(str(e))
    
    #SQLを実行するための関数
    def execQuery(self,sqls):
        try:
            rows = []
            for sql in sqls:
                self.cur.execute(sql)
                self.cnx.commit()
                rows.append(self.cur.fetchall())
            return rows

        #エラーごとの表示を変えている
        except(mysql.connector.errors.ProgrammingError) as e:
            print("Error Occured when sql executed:  " + str(e))
        except(mysql.connector.errors.DatabaseError) as e:
            print("Error Occured when sql executed(Database Error): " + str(e))           
        # except Exception(e):
        #     print(str(e))
