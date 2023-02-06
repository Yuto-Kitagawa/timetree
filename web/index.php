<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Timetree Calendar</title>
</head>
<style>
    .weekday {
        width: 100%;
        border-right: 1px solid lightgray;
        border-bottom: 1px solid lightgray;
        border-top: 1px solid lightgray;
        text-align: center;
    }

    .weekday:nth-child(1) {
        border-left: 1px solid lightgray;
    }

    .date:nth-child(1) {
        background: rgb(255, 226, 226);
    }

    .date:nth-child(7) {
        background: rgb(226, 246, 255);
    }

    .today {
        background: rgb(226, 255, 227);
    }

    .date {
        width: calc(100%/7);
        font-weight: lighter;
        padding: 0 0 50px 5px;
        border-right: 1px solid lightgray;
        position: relative;
    }

    .date:nth-child(1) {
        border-left: 1px solid lightgray;
    }

    .week {
        border-bottom: 1px solid lightgray;
    }

    [class^="events"] {
        position: absolute;
        left: 50%;
        font-size: .8em;
        transform: translateX(-50%);
        width: 95%;
        margin: auto;
        background: tomato;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        padding-left: 6px;
    }

    [class^="events"]:hover {
        color: white;
    }

    .events1 {
        top: 25px;
    }

    .events2 {
        top: 45px;
    }
</style>

<body>
    <div class="calendar-wrapper col-12 col-sm-12 col-md-8 col-lg-8 m-auto">
        <div id="title" class="display-6 text-center mt-5"></div>
        <div id="Calendar" class="d-flex justify-content-around flex-column mt-3">
            <div class="weekday-wrapper d-flex justify-content-around align-items-center">
                <div class="weekday"><span class="text-danger">日</span></div>
                <div class="weekday">月</div>
                <div class="weekday">火</div>
                <div class="weekday">水</div>
                <div class="weekday">木</div>
                <div class="weekday">金</div>
                <div class="weekday"><span class="text-primary">土</span></div>
            </div>
        </div>
    </div>

    <script>
        'use strict'
        class Calendar {

            constructor() {
                let d = new Date();
                this.YEAR = d.getFullYear();
                this.MONTH = d.getMonth();
                this.DATE = d.getDate();

                document.getElementById('title').textContent = `${this.YEAR}年 ${(this.MONTH+1)}月`;

                this.loadCalendar();
            }

            loadCalendar() {
                const CALENDAR_ELEM = document.getElementById('Calendar');
                const MAX_DATE = new Date(this.YEAR, this.MONTH + 1, 0);
                const WEEKDAY = ['日', '月', '火', '水', '木', '金', '土'];

                const YEAR = this.YEAR;
                const MONTH = this.MONTH;
                const DATE = this.DATE;

                let week;
                let dateElem;
                let day = 0;
                const SCHEDULE_DATES = [];

                let getMonthEvents = () => {
                    const fd = new FormData();
                    // arrow function にするとthisも使えるようになる(なんでかはしらんけど)
                    fd.append('year', this.YEAR);
                    fd.append('month', this.MONTH + 1);
                    fd.append('date', MAX_DATE.getDate());

                    const param = {
                        method: "POST",
                        header: "Content-type: json;",
                        body: fd
                    };

                    fetch("./action/get-event.php", param).then((res) => {
                        if (res.status == 200) {
                            return res.json();
                        } else {
                            throw new Error(`リクエスト失敗: ${res.status} ${res.statusText}`);
                        }
                    }).then((data) => {
                        if (data[0] == "True") {
                            for (let i = 0; i < data[1].length; i++) {
                                SCHEDULE_DATES.push(data[1][i].start_time);
                            }
                            main()
                        } else {
                            window.alert('今月は予定がないみたいです。予定を追加しましょう。')
                        }
                    }).catch((error) => {
                        console.log(error);
                    });
                }

                let insertDate = (year, month, date) => {
                    dateElem = document.createElement('div');

                    if (year == this.YEAR && month == this.MONTH && date == this.DATE) {
                        dateElem.setAttribute('class', 'date today');
                    } else {
                        dateElem.setAttribute('class', 'date');
                    }

                    dateElem.textContent = `${date}`;

                    //三項演算(if文を短くしたもの)
                    (month + 1).toString().length == 1 ? month = "0" + (month + 1) : month = (month + 1)
                    date.toString().length == 1 ? date = "0" + date : date = date

                    let temp_date = year + "-" + month + "-" + date;
                    let scheduleCounter = 1;

                    SCHEDULE_DATES.forEach(val => {
                        if (val.includes(temp_date)) {
                            let events = document.createElement('a');
                            events.setAttribute('class', `events${scheduleCounter} d-block`);
                            events.setAttribute('href', '#');
                            events.textContent = 'イベント';
                            dateElem.appendChild(events);
                            scheduleCounter++;
                        }
                    });

                    week.appendChild(dateElem);
                }

                function main() {

                    let weekCounter = 0;
                    /**
                     * 実行時時の月の1~月末まで繰り返す。
                     * もし1日が日曜日でなければ、1週目の先頭に先月の月末の日付を曜日分だけ追加する。
                     * 月末も同様、日曜日までの空白分来月を追加する。
                     */
                    for (let i = 1; i <= parseInt(MAX_DATE.getDate()); i++) {

                        day = new Date(YEAR, MONTH, i).getDay();

                        //週初め初期化
                        //1日、または7で割るとあまりが0(変数は0で始まっているので日曜日が0になる)のとき、新しい週が始まるので週の要素を生成
                        if (weekCounter % 7 == 0 || i == 1) {
                            week = document.createElement('div');
                            week.setAttribute('class', 'week d-flex');
                        };

                        //月初めの時、1日の曜日までスキップする
                        if (i == 1) {
                            //日曜日でなければ追加(日曜日なら追加はしない)
                            if (day != 0) {
                                //追加する数(曜日の数だけ追加する)
                                const TO_SKIP = day;
                                //先月末の日付を取得する
                                let beforeMonthLastDate = new Date(YEAR, MONTH, 0).getDate();
                                //(月末 - 追加する数)から1ずつ増やしていく(繰り返す回数は曜日分だけなので今月にはならない)
                                for (let j = (beforeMonthLastDate - TO_SKIP + 1); j <= beforeMonthLastDate; j++) {
                                    insertDate(YEAR, (MONTH - 1), j);
                                    weekCounter++;
                                }
                            }
                            //iは1なので、先月分だけではなく、1日分も実行しなければならない
                            insertDate(YEAR, MONTH, i);
                            weekCounter++;
                        } else {
                            insertDate(YEAR, MONTH, i);
                            weekCounter++;
                        };

                        //月末の時、来月分も追加する
                        if (i == parseInt(MAX_DATE.getDate())) {
                            //weekCounterまでしか追加できていないので、7 -weekCounterで残りの数を計算
                            let remain = 7 - weekCounter;
                            //追加するのは1日からなので、1から始める。
                            for (let k = 1; k <= remain; k++) {
                                insertDate(YEAR, MONTH + 1, k);
                                i++;
                            }
                            weekCounter += remain;
                        };

                        //週終わりで改行(weekCounterを最後追加済みになので、weekCoutnerが0でここは実行されず、weekCounter=7のときに実行される(土曜日のぶんを追加し終わった時weekCounter=7になる))
                        if (weekCounter % 7 == 0) {
                            CALENDAR_ELEM.appendChild(week);
                            weekCounter = 0;
                        };
                    }
                }

                /**
                 * 実行時の「年・月・月末の日付」
                 */
                let res = getMonthEvents(YEAR, MONTH + 1);

            }
        }

        window.onload = () => {
            const calendar = new Calendar();
        }
    </script>

</body>

</html>