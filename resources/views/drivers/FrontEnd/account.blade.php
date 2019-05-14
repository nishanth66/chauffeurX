@include('drivers.FrontEnd.header')
@include('drivers.FrontEnd.sideBar')
<style>

</style>
            <div class="col-md-2 col-sm-2"></div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <span class="accounts-edit-details">Next Membership Payment: 06/05/2019</span> <br/>
                <span class="accounts-edit-details">Card on file: ************2121</span> <i class="fa fa-pencil account-edit-pencil"></i><br/>
                <span class="accounts-edit-details">Invoice History</span> <br/>
                <table width="100%" class="invoice-table">
                    <tr>
                        <td width="40%">04/03/2019</td>
                        <td width="20%">&dollar;49</td>
                        <td width="40%"><img src="{{asset('public/image/pdfDownload.png')}}" class="pdf-download-image"></td>
                    </tr>
                    <tr>
                        <td width="40%">03/03/2019</td>
                        <td width="20%">&dollar;49</td>
                        <td width="40%"><img src="{{asset('public/image/pdfDownload.png')}}" class="pdf-download-image"></td>
                    </tr>
                    <tr>
                        <td width="40%">02/03/2019</td>
                        <td width="20%">&dollar;49</td>
                        <td width="40%"><img src="{{asset('public/image/pdfDownload.png')}}" class="pdf-download-image"></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-2 col-sm-2"></div>

</div>
</div>


<!-- jQuery CDN - Slim version (=without AJAX) -->
{{--<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}

<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            if ($('#sidebar').hasClass('active'))
            {
                $('.driver-header-name').hide();
            }
            else
            {
                $('.driver-header-name').show();
            }
        });
    });

</script>