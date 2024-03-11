<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </meta>
    <title>{{ $report_name }} - {{ $created_at }}</title>
    <style type="text/css" media="all">
    @import url("https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800")
    </style>
    <style type="text/css" media="all">
    html,
    body,
    div,
    span,
    applet,
    object,
    iframe,
    h1,
    h2,
    h4,
    h5,
    p,
    blockquote,
    pre,
    a,
    abbr,
    acronym,
    address,
    big,
    cite,
    code,
    del,
    dfn,
    em,
    img,
    ins,
    kbd,
    q,
    s,
    samp,
    small,
    strike,
    strong,
    sub,
    sup,
    tt,
    var,
    b,
    u,
    i,
    center,
    dl,
    dt,
    dd,
    ol,
    ul,
    li,
    fieldset,
    form,
    label,
    legend,
    table,
    caption,
    tbody,
    tfoot,
    thead,
    tr,
    th,
    td,
    article,
    aside,
    canvas,
    details,
    embed,
    figure,
    figcaption,
    footer,
    header,
    hgroup,
    menu,
    nav,
    output,
    ruby,
    section,
    summary,
    time,
    mark,
    audio,
    video {
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 100%;
        font: inherit;
        vertical-align: baseline;
        -webkit-text-size-adjust: none;
    }

    h3,
    h6 {
        font-weight: 300 !important;
    }

    html,
    body {
        font-family: 'Open Sans', 'Helvetica Neue', 'Segoe UI', helvetica, arial, sans-serif;
        width: 100%;
        color: #333;
        font-size: 13px;
        background: #efefef;
    }

    a,
    a:visited,
    a:active {
        color: #67ACE1;
        text-decoration: none;
    }

    a:hover {
        color: #67ACE1;
        text-decoration: underline;
    }

    .clear {
        clear: both;
        width: 0 !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    table {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .plugin-row-header {
        height: 35px;
        line-height: 35px;
        background: #f5f5f5;
        font-size: 12px;
        border: 1px solid #ddd;
    }

    .plugin-row {
        height: 40px;
        border: 1px solid #ddd;
    }

    .plugin-row td {
        padding: 10px 0;
        line-height: 20px;
    }

    .table-wrapper.details,
    .table-wrapper.see-also {
        margin: 0 0 20px 0;
    }

    .table-wrapper.details>table>tbody>tr>td {
        padding: 5px 0;
    }

    .button {
        display: block;
        float: left;
        line-height: 30px;
        background: #eee;
        border-radius: 3px;
        cursor: pointer;
        padding: 0 15px;
    }

    .button:hover {
        background: #ccc;
    }

    .expand {
        display: block;
        float: right;
        font-size: 12px;
        color: #67ACE1;
        cursor: pointer;
        font-weight: 400;
        line-height: 20px;
        margin: 0 0 0 10px;
    }

    .expand:hover {
        text-decoration: underline;
    }

    .expand-spacer {
        display: block;
        float: right;
        font-size: 12px;
        font-weight: 400;
        line-height: 20px;
        margin: 0 0 0 10px;
    }

    .details-header {
        font-size: 14px;
        font-weight: 700;
        padding: 0 0 5px 0;
        margin: 0 0 5px 0;
        border-bottom: 1px dotted #ccc;
    }

    .offline {
        background-image: -webkit-repeating-linear-gradient(135deg, transparent, transparent 5px, rgba(255, 255, 255, .2) 5px, rgba(255, 255, 255, .2) 10px) !important;
        background-image: repeating-linear-gradient(135deg, transparent, transparent 5px, rgba(255, 255, 255, .2) 5px, rgba(255, 255, 255, .2) 10px) !important;
    }

    .acas-header {
        padding: 0 10px;
    }

    .acas-header,
    .acas-footer>h1 {
        color: #fff;
        font-weight: 700;
        font-size: 15px;
        text-align: center;
    }

    .table-desc>h5 {
        color: #000;
        text-align: left;
        padding: 3px;
        font-size: 14px;
        font-weight: 300;
        letter-spacing: 1px;
        padding-top: 15px;
        padding-bottom: 15px;
    }

    #printButton {
        padding: 20px;
        font-size: 18px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    #buttonContainer {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    @media print {

        #printButton {
            display: none !important;
        }
    }
    </style>
    <script type="text/javascript">
    window.print();
    var toggle = function(id) {
        var div = document.getElementById(id);
        var button = document.getElementById(id + '-show');

        if (!div || !button) {
            return;
        }

        if (div.style.display === '' || div.style.display === 'block') {
            button.style.display = 'block';
            div.style.display = 'none';
            adjustWatermark();
            return;
        }

        button.style.display = 'none';
        div.style.display = 'block';

        adjustWatermark();
    };

    var toggleAll = function(hide) {
        if (document.querySelectorAll('div.section-wrapper').length) {
            toggleAllSection(hide);
            adjustWatermark();
            return;
        }

        var divs = document.querySelectorAll('div.table-wrapper');

        for (var i = 0, il = divs.length; i < il; i++) {
            var id = divs[i].getAttribute('id');
            var div = document.getElementById(id);
            var button = document.getElementById(id + '-show');

            if (div && button) {
                if (hide) {
                    button.style.display = 'block';
                    div.style.display = 'none';
                    adjustWatermark();
                    continue;
                }

                button.style.display = 'none';
                div.style.display = 'block';
            }
        }
        adjustWatermark();
    };

    var toggleSection = function(id) {
        var div = document.getElementById(id);
        var toggleText = document.getElementById(id.split('-')[0] + '-toggletext');

        if (!div) {
            return;
        }

        if (div.style.display !== 'none') {
            toggleText.innerText = '+';
            div.style.display = 'none';
            adjustWatermark();
            return;
        }

        toggleText.innerText = '-';
        div.style.display = 'block';

        adjustWatermark();
    };

    var toggleAllSection = function(hide) {
        var divs = document.querySelectorAll('div.section-wrapper');

        for (var i = 0, il = divs.length; i < il; i++) {
            var id = divs[i].getAttribute('id');
            var div = document.getElementById(id);
            var toggleText = document.getElementById(id.split('-')[0] + '-toggletext');

            if (div) {
                if (hide) {
                    toggleText.innerText = '+';
                    div.style.display = 'none';
                    continue;
                }

                toggleText.innerText = '-';
                div.style.display = 'block';
            }
        }
        adjustWatermark();
    };

    var adjustWatermark = function() {
        if (document.getElementById('nessus-watermark')) {
            let el = document.getElementById('nessus-watermark');
            let body = document.body;
            let html = document.documentElement;
            let height = Math.max(body.scrollHeight, body.offsetHeight,
                html.clientHeight, html.scrollHeight, html.offsetHeight);
            el.setAttribute('height', body.offsetHeight);
        }
    };
    </script>
</head>

<body>
    <div id="report"
        style="width: 1024px; box-sizing: border-box; margin: 0 auto; background: #fff; padding: 0 20px 20px 20px; border-top: #263746 solid 3px; box-shadow: 0 2px 10px rgba(0, 0, 0, .2); margin-bottom: 20px; border-radius: 0 0 3px 3px;">

        <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            let el = document.getElementById('nessus-watermark');
            let elFill = document.getElementById('nessus-watermark-fill');
            let body = document.body;
            let html = document.documentElement;
            let height = Math.max(body.scrollHeight, body.offsetHeight,
                html.clientHeight, html.scrollHeight, html.offsetHeight);
            el.setAttribute('height', height);
        });
        </script>

        <div class="clear"></div>
        <div id="buttonContainer">
            <button id="printButton">Print Report</button>
        </div>
        <h3 style="font-size: 24px; font-weight: 300;">{{ $report_name }}</h3>
        <h4 style="color: #999; border-bottom: 1px dotted #ccc; padding: 0 0 20px 0; margin: 0 0 20px 0;">
            {{ $created_at }}
            UTC</h4>
        <div class="clear"></div>
        <div xmlns="" id="idp45661628773776" style="display: block;" class="table-wrapper ">
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width=""></th>
                        <th width=""></th>
                        <th width=""></th>
                        <th width=""></th>
                        <th width=""></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td class="#91243E" style=" " colspan="1">
                            <div
                                style="box-sizing: border-box; font-size: 45px; font-weight: 300; line-height: 80px; color: #fff; text-align: center; background: #91243E; border-radius: 3px 3px 0 0; width: 98%; margin: 0;">
                                {{ $count[0] }}</div>
                        </td>
                        <td class="#DD4B50" style=" " colspan="1">
                            <div
                                style="box-sizing: border-box; font-size: 45px; font-weight: 300; line-height: 80px; color: #fff; text-align: center; background: #DD4B50; border-radius: 3px 3px 0 0; width: 98%; margin: 0;">
                                {{ $count[1] }}</div>
                        </td>
                        <td class="#F18C43" style=" " colspan="1">
                            <div
                                style="box-sizing: border-box; font-size: 45px; font-weight: 300; line-height: 80px; color: #fff; text-align: center; background: #F18C43; border-radius: 3px 3px 0 0; width: 98%; margin: 0;">
                                {{ $count[2] }}</div>
                        </td>
                        <td class="#F8C851" style=" " colspan="1">
                            <div
                                style="box-sizing: border-box; font-size: 45px; font-weight: 300; line-height: 80px; color: #fff; text-align: center; background: #F8C851; border-radius: 3px 3px 0 0; width: 98%; margin: 0;">
                                {{ $count[3] }}</div>
                        </td>
                        <td class="#67ACE1" style=" " colspan="1">
                            <div
                                style="box-sizing: border-box; font-size: 45px; font-weight: 300; line-height: 80px; color: #fff; text-align: center; background: #67ACE1; border-radius: 3px 3px 0 0; width: 98%; margin: 0;">
                                {{ $count[4] }}</div>
                        </td>
                    </tr>
                    <tr class="">
                        <td class="#ffffff" style=" " colspan="1">
                            <div
                                style="font-size: 10px; text-transform: uppercase; padding: 5px 0; text-align: center; width: 98%; box-sizing: border-box; border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; border-radius: 0 0 3px 3px;  margin: 0; margin-bottom: 15px;">
                                Critical</div>
                        </td>
                        <td class="#ffffff" style=" " colspan="1">
                            <div
                                style="font-size: 10px; text-transform: uppercase; padding: 5px 0; text-align: center; width: 98%; box-sizing: border-box; border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; border-radius: 0 0 3px 3px;  margin: 0; margin-bottom: 15px;">
                                High</div>
                        </td>
                        <td class="#ffffff" style=" " colspan="1">
                            <div
                                style="font-size: 10px; text-transform: uppercase; padding: 5px 0; text-align: center; width: 98%; box-sizing: border-box; border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; border-radius: 0 0 3px 3px;  margin: 0; margin-bottom: 15px;">
                                Medium</div>
                        </td>
                        <td class="#ffffff" style=" " colspan="1">
                            <div
                                style="font-size: 10px; text-transform: uppercase; padding: 5px 0; text-align: center; width: 98%; box-sizing: border-box; border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; border-radius: 0 0 3px 3px;  margin: 0; margin-bottom: 15px;">
                                Low</div>
                        </td>
                        <td class="#ffffff" style=" " colspan="1">
                            <div
                                style="font-size: 10px; text-transform: uppercase; padding: 5px 0; text-align: center; width: 98%; box-sizing: border-box; border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; border-radius: 0 0 3px 3px;  margin: 0; margin-bottom: 15px;">
                                Info</div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="clear"></div>
        </div>

        <div style="width: 100%;">
            <h5 xmlns="" style="font-size: 16px; font-weight: 700; margin-bottom: 20px;">TABLE OF CONTENTS</h5>
            <ul xmlns="" style="list-style-type: none; margin-bottom: 20px;">
                <li style="font-size: 14px;">
                    <a href="#idp45661628772112" style="font-weight: 700;">Vulnerabilities by category</a>
                    <ul style="list-style-type: disc; margin: 10px 0 0 20px;">
                        @foreach($vulnerabilities as $vulnerability )
                        <?php 
                        $code = str_replace('vu_', '', $vulnerability->code) ;
                        ?>
                        <li style="margin: 0 0 10px 0; color: #000000;">
                            <a href="#{{ $code }}">{{ $code }}
                                -
                                {{ $vulnerability->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </li>
            </ul>


            <h5 xmlns="" style="font-size: 16px; font-weight: 700; margin-bottom: 10px; margin-top: 20px;">
                Vulnerabilities</h5>
            <h2 xmlns="" class=""></h2>
            @foreach($vulnerabilities as $vulnerability )
            <?php 
                $code = str_replace('vu_', '', $vulnerability->code) ;
            ?>
            <div xmlns="" id="{{ $code }}"
                style="box-sizing: border-box; width: 100%; margin: 0 0 10px 0; padding: 5px 10px; background: #343a40; font-weight: 700; font-size: 14px; line-height: 20px; color: #fff;"
                class="" onclick="toggleSection('{{ $code }}-container');" onmouseover="this.style.cursor='pointer'">
                {{ $code }} - {{ $vulnerability->name }}
                <div id="{{ $code }}-toggletext" style="float: right; text-align: center; width: 8px;">
                    -
                </div>
            </div>
            <div xmlns="" id="{{ $code }}-container" style="margin: 0 0 45px 0;" class="section-wrapper">
                <div class="details-header">
                    Synopsis
                    <div class="clear"></div>
                </div>
                <div style="line-height: 20px; padding: 0 0 20px 0; overflow-wrap: break-word">
                    {{ $vulnerability->synopsis }}
                    <div class="clear"></div>
                </div>
                <div class="details-header">
                    Description
                    <div class="clear"></div>
                </div>
                <div style="line-height: 20px; padding: 0 0 20px 0; overflow-wrap: break-word">
                    {{ $vulnerability->description }}
                    <div class="clear"></div>
                </div>
                <div class="details-header">
                    Solution
                    <div class="clear"></div>
                </div>
                <div style="line-height: 20px; padding: 0 0 20px 0; overflow-wrap: break-word">
                    {{ $vulnerability->solution }}
                    <div class="clear"></div>
                </div>
                <div class="details-header">
                    Risk Factor
                    <div class="clear"></div>
                </div>
                <div style="line-height: 20px; padding: 0 0 20px 0; overflow-wrap: break-word">
                    {{ $vulnerability->risk }}
                    <div class="clear"></div>
                </div>
                <div class="details-header">
                    Solution
                    <div class="clear"></div>
                </div>
                <div style="line-height: 20px; padding: 0 0 20px 0; overflow-wrap: break-word">
                    {{ $vulnerability->solution }}
                    <div class="clear"></div>
                </div>
                <div class="details-header">
                    Plugin Output
                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
                <div
                    style="box-sizing: border-box; width: 100%; background: #eee; overflow-wrap: break-word; font-family: monospace; padding: 20px; margin: 5px 0 20px 0;">
                    {{ $vulnerability->plugin_output }}
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <div class="clear"></div>
            </div>
            @endforeach
            <div xmlns="" class="clear"></div>
            <h2 xmlns="" class=""></h2>
        </div>
        <div class="clear"></div>
    </div>
    <div
        style="width: 1024px; box-sizing: border-box; text-align: center; font-size: 12px; color: #999; padding: 10px 0 20px 0; margin: 0 auto;">
        © 2024 ARMORA, Inc. All rights reserved.
    </div>


    <script>
    document.getElementById("printButton").addEventListener("click", function() {
        window.print();
    });
    </script>
</body>

</html>