"""
参考サイト: https://note.com/soshi_oki/n/nd6026a8fd7c5

TimeTreeAPIを使用したプログラム。
内容はプログラム実行時の日付の予定を取得する。
具体的な方法として、
1. アクセストークンを取得(https://timetreeapp.com/developers/personal_access_tokens)
2. カレンダーIDを取得(TimeTreeのURLの最後の文字列)
3. HTTPヘッダーを書き換え、返却値を取得できるようにする
4. 取得するためのURLにヘッダーを指定して送信
5. 取得したjsonデータを分解して表示
"""

""" 
今回使うパッケージは5つ
1. リクエストを送信する
2. 取得したデータをjson形式で扱えるようにする)
3.4.タイムゾーンとdate型のフォーマット用
5. データベースクラス(自作) 

"""
import requests
import json
import isodate
from datetime import datetime,timedelta,timezone

from db import Database

tz_utc = timezone(timedelta(hours=0), 'UTC')
tz_jst = timezone(timedelta(hours=9), 'JST')

#タイムゾーンの調整と、適切な形式に変換
def utc_to_jst(timestamp_utc):
	timestamp_with_tz = isodate.parse_datetime(timestamp_utc)
	timestamp_jst = timestamp_with_tz.astimezone(tz_jst)
	format_dt = datetime.fromisoformat(str(timestamp_jst))
	return format_dt

#各自自分のトークン・IDに変更すること
ACCESS_token = ""
CALENDAR_ID  = ""

# ヘッダーの設定
headers = {
  "Accept": "application/vnd.timetree.v1+json",
  "Authorization": "Bearer " + ACCESS_token
}

url_get_today_schedule = "https://timetreeapis.com/calendars/" + CALENDAR_ID +"/upcoming_events?timezone=Asia/Tokyo"

res = requests.get(url=url_get_today_schedule,headers=headers)
data = res.json() # 予定の詳細情報はdata['data']に格納されている

print("今日の予定は{:<1}個".format(str(len(data['data']))))

# 予定の数を数えるための変数
schedule_counter = 1
# SQL文を格納するための変数
insert_sql_array = []

# json['data']の中身を順番に首都kう
for event in data['data']:

	#タイムゾーンの調整
	start_time = str(utc_to_jst(event['attributes']['start_at'])).replace('+09:00',"")
	end_time = str(utc_to_jst(event['attributes']['end_at'])).replace('+09:00',"")
	

	insert_sql = f"INSERT INTO timetree (id,title,start_time,end_time) VALUES ({event['id']!r},{event['attributes']['title']!r},{start_time!r},{end_time!r});"
	insert_sql_array.append(insert_sql)

	# 今回練習としてformatを使ってみた。
	print("予定{:<1s}: {:<8s}".format(str(schedule_counter), event['attributes']['title']))
	schedule_counter += 1

# インスタンス生成→SQLをdatabaseクラスに送信
db = Database()
db.execQuery(insert_sql_array)


