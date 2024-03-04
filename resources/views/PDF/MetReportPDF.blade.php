<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ $title }}</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: left;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td colspan="4">{{ $title }}</td>

                <td colspan="4"><small>Generated on: {{ now()->format('jS M Y H:i:s') }}</small></td>
            </tr>

            <tr class="top">
                <td colspan="8">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://inkeit-innovation.com/labmgt/logo.png"
                                    style="width: 90%; max-width: 300px" />
                            </td>
                            <td>
                                From: {{ $records->first()->created_at->format('D, jS F Y') }}<br />
                                To: {{ $records->last()->created_at->format('D, jS F Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            {{-- <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Sparksuite, Inc.<br />
                                12345 Sunny Road<br />
                                Sunnyville, CA 12345
                            </td>

                            <td>
                                Acme Corp.<br />
                                John Doe<br />
                                john@example.com
                            </td>
                        </tr>
                    </table>
                </td>
            </tr> --}}

            <tr class="heading">
                <td>Production Date</td>
                <td>Al<sub>2</sub>O<sub>3</sub></td>
                <td>CaO</td>
                <td>Fe</td>
                <td>MgO</td>
                <td>Mn</td>
                <td>P</td>
                <td>SiO<sub>2</sub></td>
            </tr>
            @foreach ($records as $record)
                <tr class="details">
                    <td>{{ $record->created_at->format('jS M Y') }}</td>
                    <td>{{ $record->Al2O3 }}</td>
                    <td>{{ $record->CaO }}</td>
                    <td>{{ $record->Fe }}</td>
                    <td>{{ $record->MgO }}</td>
                    <td>{{ $record->Mn }}</td>
                    <td>{{ $record->P }}</td>
                    <td>{{ $record->SiO2 }}</td>
                </tr>
            @endforeach


            {{-- <tr class="details">
                <td>Check</td>

                <td>1000</td>
            </tr> --}}

            {{-- <tr class="heading">
                <td>Item</td>

                <td>Price</td>
            </tr> --}}

            {{-- <tr class="item">
                <td>Website design</td>

                <td>$300.00</td>
            </tr> --}}

            {{-- <tr class="item">
                <td>Hosting (3 months)</td>

                <td>$75.00</td>
            </tr> --}}

            {{-- <tr class="item last">
                <td>Domain name (1 year)</td>

                <td>$10.00</td>
            </tr> --}}
            <tr class="total">
                <td>Total:</td>
                <td>{{ $records->sum('Al2O3') }}</td>
                <td>{{ $records->sum('CaO') }}</td>
                <td>{{ $records->sum('Fe') }}</td>
                <td>{{ $records->sum('MgO') }}</td>
                <td>{{ $records->sum('Mn') }}</td>
                <td>{{ $records->sum('P') }}</td>
                <td>{{ $records->sum('SiO2') }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
