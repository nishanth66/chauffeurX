@if($array['status'] == 1)
    <body style="width: 100%;line-height: 25px;background-color: #eff0f7">
    <center>
        <div style="padding-top: 5%;padding-bottom: 5%;">
            <h3>Hello {{$array['name']}}</h3>
            <p>Greetings from ChauffeurX! <br/> Your Documents are Verified Successfully!<br/> You can now Start Riding on ChauffeurX!<br><br><br/><br/></p>
            <p>Thank You <br/> ChauffeurX Team</p>
        </div>
    </center>
    </body>
@else
    <body style="width: 100%;line-height: 25px;background-color: #eff0f7">
    <center>
        <div style="padding-top: 5%;padding-bottom: 5%;">
            <h3>Hello {{$array['name']}}</h3>
            <p>We are Very Sorry to Inform You that, Your Document Verification have Failed <br/> Reason May be incorrect Document or Poor Clarity of the Image Submitted! <br/>
                Need not to worry, You can login again and You will redirected to the Licence Page!<br>
                to Login <a style="color: black" href="{{url('driver/login')}}"><button type="button" style="background-color: #4D68B0;color: white;border: 1px solid gray;cursor: pointer;height: 30px;">Click Here</button></a></p> <br/><br/><br/>
            <p>Thank You <br/> ChauffeurX Team</p>
        </div>
    </center>
    </body>
@endif