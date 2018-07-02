<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Agenda</title>
    <style type="text/css">

        #mais {
            margin-top: 0px;
            text-decoration: none;
            height: 45px;
            text-align: center;
            font-size: 28px;
            font-family: Arial, Verdana;
        }

        #mais a:link {text-decoration: none; color: #aaa; }
        #mais a:visited {text-decoration: none; color: #aaa; }
        #mais a:active {text-decoration: none; color: #aaa; }
        #mais a:hover {text-decoration: none; color: #aaa; }


        #maisplus {
            margin-top: 0px;
            text-decoration: none;
            height: 45px;
            text-align: center;
            font-size: 28px;
            font-family: Arial, Verdana;
        }

        #maisplus a:link {text-decoration: none; color: #5ab5df; }
        #maisplus a:visited {text-decoration: none; color: #5ab5df; }
        #maisplus a:active {text-decoration: none; color: #5ab5df; }
        #maisplus a:hover {text-decoration: none; color: #5ab5df; }


        #maisplusred {
            margin-top: 0px;
            text-decoration: none;
            height: 45px;
            text-align: center;
            font-size: 28px;
            font-family: Arial, Verdana;
        }

        #maisplusred a:link {text-decoration: none; color: #ff0000; }
        #maisplusred a:visited {text-decoration: none; color: #ff0000; }
        #maisplusred a:active {text-decoration: none; color: #ff0000; }
        #maisplusred a:hover {text-decoration: none; color: #ff0000; }



            /* Navigation */
        ul#list-nav {
            list-style:none;
            margin:20px;
            padding:0;
            width:525px
        }

        ul#list-nav li {
            display:inline
        }

        ul#list-nav li a {
            text-decoration:none;
            width:105px;
            height:35px;
            background:#c7c7c7;
            color:#000;
            float:left;
            text-align:center;
            border-left:1px solid #fff;
        }

        ul#list-nav li a:hover {
            background:#dcdcdc;
            color:#000
        }

        ul {/* Remove margin for all <ul>s (and padding, because different browsers have different default styles) */
            margin-left: 0;
            padding-left: 0;
        }
            /* ========== */
        .calendar {
            font-family: Arial, Verdana, Sans-serif;
            width: 100%;
            min-width: 960px;
            border-collapse: collapse;
        }

        .calendar tbody tr:first-child th {
            color: #505050;
            margin: 0 0 10px 0;
        }

        .day_header {
            font-weight: normal;
            text-align: center;
            color: #757575;
            font-size: 10px;
        }

        .calendar td {
            width: 14%; /* Force all cells to be about the same width regardless of content */
            border:1px solid #CCC;
            height: 100px;
            vertical-align: top;
            font-size: 10px;
            padding: 0;
        }

        .calendar td:hover {
            background: #F3F3F3;
        }

        .day_listing {
            display: block;
            text-align: right;
            font-size: 12px;
            color: #2C2C2C;
            padding: 5px 5px 0 0;
        }

        div.today {
            background: #E9EFF7;
            height: 100%;
        }

        textarea {
            width: 100%;
            height: 100;
        }

        th a:link { text-decoration: none; color:#aaa; }
        th a:visited { text-decoration: none; color:#aaa; }
        th a:active { text-decoration: none; color:#aaa; }
        th a:hover { text-decoration: none; color:#aaa; }


        .modal-overlay {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            background: #131313;
            opacity: .85;
            filter: alpha(opacity=85);
            z-index: 101;
        }
        .modal-window {
            position: fixed;
            top: 50%;
            left: 50%;
            margin: 0;
            padding: 0;
            z-index: 102;
            background: #fff;
            border: solid 4px #000;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
        }
        .close-window {
            position: absolute;
            width: 47px;
            height: 47px;
            right: -23px;
            top: -23px;
            background: transparent url(<?php echo "$base/application/views/common/images/icon_close.png"; ?>) no-repeat scroll right top;
            text-indent: -99999px;
            overflow: hidden;
            cursor: pointer;
        }

    </style>

</head>
<body>
<?php echo $calendar;?>
</body>
</html>