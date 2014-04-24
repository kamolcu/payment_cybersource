@extends('layout.default')

@section('content')
<form id="payment_confirmation" action="https://testsecureacceptance.cybersource.com/silent/pay" method="post"/>

@foreach($request as $name => $value)
    <?php
        $params[$name] = $value;
    ?>
@endforeach

    <fieldset id="confirmation">
    <legend>Signed Data Fields</legend>
These fields have been signed on your server, and a signature has been generated.  This will <br> detect tampering with these values as they pass through the consumers browser to the SASOP endpoint.<BR></BR>
    <div>
        <?php
            foreach($params as $name => $value) {
                echo "<div>";
                echo "<span class=\"fieldName\">" . $name . "</span><span class=\"fieldValue\">" . $value . "</span>";
                echo "</div>\n";
            }
        ?>
    </div>
</fieldset>

<?php
        foreach($params as $name => $value) {
            echo "<input type=\"hidden\" id=\"" . $name . "\" name=\"" . $name . "\" value=\"" . $value . "\"/>\n";
        }
        echo "<input type=\"hidden\" id=\"signature\" name=\"signature\" value=\"" . sign($params) . "\"/>\n";
    ?>

    <input type="hidden" name="locale" value="en">
    <fieldset>
        <legend>Unsigned Data Fields</legend>
        Card data fields are posted directly to CyberSource, together with the fields above.  These field <br>
        names will need to be included in the unsigned_field_names.
        <BR></BR>
        <div id="UnsignedDataSection" class="section">
        <span>card_type:</span><input type="text" name="card_type"><br/>
        <span>card_number:</span><input type="text" name="card_number"><br/>
        <span>card_expiry_date:</span><input type="text" name="card_expiry_date"><br/>
	</div>
    </fieldset>
  <input type="submit" id="submit" value="Confirm "/>

</form>
@stop