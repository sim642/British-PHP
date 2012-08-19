<?php
$options = array();

foreach ($argv as $arg){
    preg_match('/\-\-(\w*)\=?(.+)?/', $arg, $value);
    if ($value && isset($value[1]) && $value[1])
        $options[$value[1]] = isset($value[2]) ? $value[2] : null;
}

if (!isset($options['file'])){
    die("where iz file?");
}
else {
    $Code = file_get_contents($options['file']);
    $OutputFile = str_replace(".b", ".php", $options['file']);
}


$syntax = array(
    "In Case It Is True That" => "if",
    "And on the possibility that" => "elseif",
    "But what if none of the above is true? well, in that case" => 'else',
    "Show My Readers" => "echo",
    "£" => "$",
    "Is, in fact" => "==",
    "Is not" => "!=",
    "Is now" => "=",
    "Our coding shall begin at once!" => "/*<?php*/",
    "And that was it my good fellas!" => "/*?>*/",
    "Every Single one of the items in" => "foreach (",
    "Should be Known as" => "as",
    "and should be treated as follow" => ")",
    "Are now" => "= array",
    "And then go down a line if you may." => "echo '\n';",
    "cheerio(" => "die(",
    "May you check this pattern for me?(" => "preg_match(",
    "someone declared the follow?(" => "isset(",
    "The content of the following file(" => "file_get_contents(",
    "The Replacement as follow(" => "str_replace(",
    "The Replacement as follow without regarding such subjects as capital letters(" => "str_ireplace(",
    "Please execute the following code(" => "eval(",
    "May you open this file for me?(" => "fopen(",
    "Now please, if you may, write the following to said file(" => "fwrite(",
    "And after all of that, please close said file(" => "fclose(",
    "while the next statement is correct:" => "while",
    "please do as follow" => "",
    " should be raised by one."=>"++;",
    "is smaller than" => "<",
    "is bigger than" => ">",
    "is smaller than or equal to" => "=<",
    "is bigger than or equal to" => "=>",
    "should be added with the following string:" => ".=",

    );


foreach($syntax as $British => $PHP){
  $Code = str_ireplace($British, $PHP, $Code);
}
echo "Your code output is: \n";
eval($Code);
if (isset($options['printerrors']) && $options['printerrors'] == True){
    echo $Code;
}
$Code = str_ireplace("/*<?php*/", "<?php", $Code);
$Code = str_ireplace("/*?>*/", "?>", $Code);
$handle = fopen($OutputFile, 'w') or die("\nCannot write new file:  ".$OutputFile);
fwrite($handle, $Code);
fclose($handle);
echo "\n\nYour php file is now ready as: \n" . $OutputFile . "\n";

?>
