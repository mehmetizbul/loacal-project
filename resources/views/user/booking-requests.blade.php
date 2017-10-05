@extends('user.accountcommon')

@section('accountheader')
    <div class="container-fluid">
        <table class="table">
            <thead>
            <tr>
                <th>Status</th>
                <th>#</th>
                <th>Experience</th>
                <th>Dates Requested</th>
                <th># of people</th>
                <th>Total Price</th>
                <th>Earning</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row"><i class="fa fa-circle-o icon-green" aria-hidden="true"> Paid</i></th>
                <td>1</td>
                <td>Loacal Tour with cherry picking</td>
                <td>12/03/2017, 15/04/2018</td>
                <td>3 Adult, 1 Child</td>
                <td>£299</td>
                <td>Total Price * 0.86</td>
            </tr>
            <tr>
                <th scope="row"><i class="fa fa-circle-o icon-red" aria-hidden="true"> Cancelled</i></th>
                <td>2</td>
                <td>Off road ride at Karpaz</td>
                <td>18/08/2017</td>
                <td>1 Adult</td>
                <td>£899</td>
                <td>Total Price * 0.86</td>
            </tr>
            <tr>
                <th scope="row"><i class="fa fa-circle-o icon-grey" aria-hidden="true"> Waiting Payment</i></th>
                <td>3</td>
                <td>Swimming with a loacal in mediterranean sea</td>
                <td>34/09/2023</td>
                <td>83 Adult, 27 Child</td>
                <td>£12,945</td>
                <td>Total Price * 0.86</td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection