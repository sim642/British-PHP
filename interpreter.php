<?php
//Get cli args
$options = array();

foreach ($argv as $arg){
    preg_match('/\-\-(\w*)\=?(.+)?/', $arg, $value);
    if ($value && isset($value[1]) && $value[1])
        $options[$value[1]] = isset($value[2]) ? $value[2] : null;
}
//make sure a file is set in the cli
if (!isset($options['file'])){
    die("Alfred! where is my file?");
}
else {
    $Code = file_get_contents($options['file']); //get the content of the file
    $OutputFile = str_replace(".b", ".php", $options['file']); //set the output name
}

//Array of the British PHP command as key and the PHP one as the value
$syntax = array(
    "In Case It Is True That" => "if",
    "And on the possibility that" => "elseif",
    "But what if none of the above is true? well, in that case" => 'else',
    "Show My Readers" => "echo",
    "£" => "$",
    "Is, in fact" => "==",
    "Is not" => "!=",
    "Is now" => "=",
    "Our coding shall begin at once!" => "/*<?php*/", //set as comment so Eval() will work
    "And that was it my good fellas!" => "/*?>*/",    //see comment above
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

function Comparer($First, $Second){
	return strlen($Second) - strlen($First);
}

uksort($syntax, "Comparer"); // sorts syntax array in british order

//loop for the syntax array an replace each british commaned with the php one
foreach($syntax as $British => $PHP){
  $Code = str_ireplace($British, $PHP, $Code);
}

echo "Your code output is: \n";
//run the code
eval($Code);
//remove comment marks from opening and closing php tags
$Code = str_ireplace("/*<?php*/", "<?php", $Code);
$Code = str_ireplace("/*?>*/", "?>", $Code);
//open the new file and write the PHP code into it
$handle = fopen($OutputFile, 'w') or die("\nCannot write new file:  ".$OutputFile);
fwrite($handle, $Code);
fclose($handle);
echo "\n\nYour php file is now ready as: \n" . $OutputFile . "\n";

?>
