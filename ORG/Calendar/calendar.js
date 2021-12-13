//*********************************************一个月里的天数
//结构体函数
function arrayOfDaysInMonth(isLeapYear)
 {
    this[0] = 31;
    this[1] = 28;
    if (isLeapYear)
    this[1] = 29;
    this[2] = 31;
    this[3] = 30;
    this[4] = 31;
    this[5] = 30;
    this[6] = 31;
    this[7] = 31;
    this[8] = 30;
    this[9] = 31;
    this[10] = 30;
    this[11] = 31;

}
function daysInMonth(month, year)
 {
    var isLeapYear = (year % 4 == 0) && ((year % 100 != 0) || (year % 400 != 0));
    var monthDays = new arrayOfDaysInMonth(isLeapYear);
    return monthDays[month];

}
function calendar(id)
 {
    var monthNames = "JanFebMarAprMayJunJulAugSepOctNovDec";
    var today = new Date();
    var day = today.getDate();
    //1~31
    var month = today.getMonth();
    //0~11
    if (navigator.userAgent.indexOf("MSIE") > 0)
    {
        var year = today.getYear();
        //firefox加1900

    }
    else
    {
        var year = today.getYear() + 1900;

    }
    var numDays = daysInMonth(month, year);
    //当年当月的天数
    var firstDay = today;
    firstDay.setDate(1);
    //当月第一天
    var startDay = firstDay.getDay();
    //获取星期数,返回0~6
    var column = 0;
    var str = "<table id=t width=200 height=170 style=\"border:5px solid #9badce;\"><tr align=center  style=\"color:red\"><td  colspan=7>";
    str = str + monthNames.substring(3 * month, 3 * (month + 1)) + "&nbsp;&nbsp;&nbsp;&nbsp;" + year;
    str = str + "</td></tr>";
    str = str + "<tr style=\"font-size:12px;color:red\"><td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td></tr>";

    str = str + "<tr>";
    for (i = 0; i < startDay; i++)
    {
        str = str + "<td>&nbsp;</td>";
        column++;

    }
    for (i = 1; i <= numDays; i++)
    {
        var s = "" + i;
        if (s == day)
        {
            str = str + "<td align=center style=\"background-color:#ccffcc;font-size:12px;font-weight:700;width:20px;height:20px;\">" + s + "</td>";
        }
        //	s=s.link("javascript:dayClick("+i+")");	
        else
        {
            str = str + "<td align=center style=\"background-color:#e9e5df;font-size:12px;width:20px;height:20px;\">" + s + "</td>";
        }
        if (++column == 7)
        {
            str = str + "</tr><tr>";
            column = 0;

        }

    }
    str = str + "</table>";
    document.getElementById(id).innerHTML = str;

}