<?php
//$table = $wpdb->prefix . "GoogleForms";
//$sql = `SELECT * FROM $table`;

global $wpdb;

$allposts = $wpdb->get_results("SELECT * FROM wp_GoogleForms", ARRAY_A);
//print_r($allposts);


$last = count($allposts) - 1;
foreach ($allposts as $i => $row) {
    $isFirst = ($i == 0);
    $isLast = ($i == $last);

    $formID = $row['formID'];

    add_shortcode(('GoogleForm' . $formID), 'sample_shortcode');
}

function sample_shortcode()
{
    global $wpdb;

    $allposts = $wpdb->get_results("SELECT * FROM wp_GoogleForms", ARRAY_A);

    $last = count($allposts) - 1;
    foreach ($allposts as $i => $row) {
        $isFirst = ($i == 0);
        $isLast = ($i == $last);

        return $row['convertedFormHTML'];
        $formID = $row['formID'];
        //DISPLAY ALL DATA FROM ROW:    // print_r($row); 

        add_shortcode(('GoogleForm' . $formID), 'sample_shortcode');
    }

    //return "HELLO TEST ME";
}

//CHANGE GoogleForm to unique name supplied by user SELECTED FROM DATABASE

echo "<pre>[<code>sample_shortcode</code>]</pre>";



/*
function sample_shortcode()
{
    return "HELLO TEST ME";
}

//CHANGE GoogleForm to unique name supplied by user SELECTED FROM DATABASE
add_shortcode('GoogleForm', 'sample_shortcode');
echo "<pre>[<code>sample_shortcode</code>]</pre>";


*/