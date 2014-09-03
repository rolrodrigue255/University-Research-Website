<!DOCTYPE html>
<html>
<body>

<h1 align = center>Analyze Research Production of CS Departments</c></h1>

<body bgcolor="#A9A9A9">

<p>Please enter your Query information below:</p>

Analyze: <select id="u1">
<option value="UTPA" selected="selected">UTPA</option>
<option value="UTB">UTB</option>
<option value="UTEP">UTEP</option>
<option value="UTSA">UTSA</option>
<option value="0">None</option>
</select> and

<select id="u2">
<option value="UTPA">UTPA</option>
<option value="UTB" selected="selected">UTB</option>
<option value="UTEP">UTEP</option>
<option value="UTSA">UTSA</option>
<option value="0">None</option>
</select></br></br>

Year Range:
<input type="text" name="Year" id="y1" value = "-"> to 
<input type="text" name="Year2" id = "y2" value = "-"></br></br>

<form>Include only articles with titles containing a certain string (e.g. "XML", "Database"):
<input type="text" id="Keyword" value = "-">
</form></br>

Custom Author Search (separate author names with commas)
<form> Analyze:
<input type = "text" id="Custom1" value = "-">
and: 
<input type = "text" id="Custom2" value = "-">
</form></br>


<button onclick= "getInfo()">Show Queries</button></br></br>




<form method = "post" action = "#">
       <div>
        <label for="query" id = "queryLabel" style = "display:none;">Query 1:</label><br />
        <textarea name="query" id="query" rows="7" cols="50" style = "display:none;">
			0
        </textarea>      
       </div>
	   <input type = "button" id = "submit1" value = "Get Query 1 results" style = "display:none;"/> 
	  
</form>


<form method = "post" action = "#">
       <div>
        <label for="query2" id = "queryLabel2" style = "display:none;">Query 2:</label><br />
        <textarea name="query2" id="query2" rows="7" cols="50" style = "display:none;">
			0
        </textarea>      
       </div>
	   <input type = "button" id = "submit2" value = "Get Query 2 results" style = "display:none;"/> 
	  	
</form>


<script>
function getValues()
{
    //get values of select forms
	e = document.getElementById("u1");
	u1 = e.options[e.selectedIndex].value;
	d = document.getElementById("u2");
	u2 = d.options[d.selectedIndex].value;
    
    //get values of year forms
	y1 = document.getElementById('y1').value;
	y2 = document.getElementById('y2').value;
	
	//get value of key form
	key = document.getElementById("Keyword").value;
	
	//test strings for university department authors
	listUTPA = '"Artem Chebotko", "John Abraham", "Emmett Tomai"';
	listUTB = '"Nazmul Islam", "Liyu Zhang", "Yingchen Yang"';
	listUTEP = '"Yoonsik Cheon", "Martine Ceberio", "Olac Fuentes"';
	listUTSA = '"Tom Bylander", "Turgay Korkmaz", "Jianhua Ruan"';
	
	//query statements for including key and year
	contain = ' and contains($x/title, "' +key+ '") ';
	year = ' and $x/year >= '+y1+ ' and $x/year <= '+y2+ ' ';
	
	//get values of Custom Author Search forms
	custom1 = document.getElementById("Custom1").value;
	custom2 = document.getElementById("Custom2").value;
	
	//splits the Custom Author Search form values by the commas
	split1 = custom1.split(",");
	split2 = custom2.split(",");
	
	//holds the complete lists of authors to be used in the queries
	total1 = "";
    total2 = "";
    
    //count variables used to skip the first comma in the total author lists
    count1 = 0;
    count2 = 0;
	
	//for statement that adds up the array elements to create total1
	for (var x in split1)
    {
        if (count1 == 0)
        {
            total1 = total1 + '"' + split1[x] + '"';
            count1++;
            continue;
        }
        
        total1 = total1 + ',"' + split1[x] + '"';
    }
    
    //for statement that adds up the array elements to create total2
    for (var x in split2)
    {
        if (count2 == 0)
        {
            total2 = total2 + '"' + split2[x] + '"';
            count2++;
            continue;
        }
        
        total2 = total2 + ',"' + split2[x] + '"';
    }
    
    //used to test whether or not there are illegal characters in the year, key, and custom search forms
	test = 0
    
    //test for illegal characters in the year forms
	if (y1.indexOf("\"") != -1 || y1.indexOf(";") != -1 || y1.indexOf("/") != -1 || y2.indexOf("\"") != -1 || y2.indexOf(";") != -1 || y2.indexOf("/") != -1) 
    {
    alert("Some of the characters you have entered for year range are not allowed. Please use only letters and numbers.");
    test = 1;
	}
    
    //test for illegal characters in key form
    if (key.indexOf("\"") != -1 || key.indexOf(";") != -1 || key.indexOf("/") != -1) 
    {
    alert("Some of the characters you have entered are not allowed. Please use only letters and numbers.");
    test = 1;
	}
	
	//test for illegal characters in both Custom Author Search forms
	if (custom1.indexOf("\"") != -1 || custom1.indexOf(";") != -1 || custom1.indexOf("/") != -1 || custom2.indexOf("\"") != -1 || custom2.indexOf(";") != -1 || custom2.indexOf("/") != -1) 
    {
    alert("Some of the characters you have entered for Custom Author Search are not allowed. Please use only letters and numbers.");
    test = 1;
	}
}
</script>

<script> // Single Custom
function getSingleCustom()
{
    document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + total1 + ') for $item in $List return (local:getPapers($item))';

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'none';
    document.getElementById("queryLabel2").style.display = 'none';
    document.getElementById("submit2").style.display = 'none';
}

function getSingleCustomKey()
{
    document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + total1 + ') for $item in $List return (local:getPapers($item))';

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'none';
    document.getElementById("queryLabel2").style.display = 'none';
    document.getElementById("submit2").style.display = 'none';
}

function getSingleCustomKeyYear() 
{
    document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + key + 'return $x/titles }; let $List:= (' + total1 + ') for $item in $List return (local:getPapers($item))';

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'none';
    document.getElementById("queryLabel2").style.display = 'none';
    document.getElementById("submit2").style.display = 'none';
}

function getSingleCustomYear() 
{
    document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + total1 + ') for $item in $List return (local:getPapers($item))';

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'none';
    document.getElementById("queryLabel2").style.display = 'none';
    document.getElementById("submit2").style.display = 'none';
}
</script> 

<script> // Double Custom
function getDoubleCustom() 
{
    document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + total1 + ') for $item in $List return (local:getPapers($item))';
    document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + total2 + ') for $item in $List return (local:getPapers($item))';	
    
    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'inline';
    document.getElementById("queryLabel2").style.display = 'inline';
    document.getElementById("submit2").style.display = 'inline';	
}

function getDoubleCustomKey() 
{
    document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + total1 + ') for $item in $List return (local:getPapers($item))';
    document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + total2 + ') for $item in $List return (local:getPapers($item))';		

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'inline';
    document.getElementById("queryLabel2").style.display = 'inline';
    document.getElementById("submit2").style.display = 'inline';	
}

function getDoubleCustomKeyYear() 
{
    document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + contain + 'return $x/titles }; let $List:= (' + total1 + ') for $item in $List return (local:getPapers($item))';
    document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + contain + 'return $x/titles }; let $List:= (' + total2 + ') for $item in $List return (local:getPapers($item))';				
    
    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'inline';
    document.getElementById("queryLabel2").style.display = 'inline';
    document.getElementById("submit2").style.display = 'inline';	
}

function getDoubleCustomYear() 
{
    document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + total1 + ') for $item in $List return (local:getPapers($item))';
    document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + total2 + ') for $item in $List return (local:getPapers($item))';	

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'inline';
    document.getElementById("queryLabel2").style.display = 'inline';
    document.getElementById("submit2").style.display = 'inline';	
}
</script>

<script> // Single Queries
function getQuery() 
{
	if (u1 == "UTPA")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + listUTPA + ') for $item in $List return (local:getPapers($item))';	
	}
	else if (u1 == "UTB")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + listUTB + ') for $item in $List return (local:getPapers($item))';
	}
	else if (u1 == "UTEP")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + listUTEP + ') for $item in $List return (local:getPapers($item))';		
	}
	else 
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + listUTSA + ') for $item in $List return (local:getPapers($item))';
    }

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'none';
    document.getElementById("queryLabel2").style.display = 'none';
    document.getElementById("submit2").style.display = 'none';
}

function getQueryKey()
{
	if (u1 == "UTPA")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + listUTPA + ') for $item in $List return (local:getPapers($item))';	
	}
	else if (u1 == "UTB")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + listUTB + ') for $item in $List return (local:getPapers($item))';		
	}
	else if (u1 == "UTEP")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + listUTEP + ') for $item in $List return (local:getPapers($item))';		
	}
	else
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + listUTSA + ') for $item in $List return (local:getPapers($item))';
    }

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'none';
    document.getElementById("queryLabel2").style.display = 'none';
    document.getElementById("submit2").style.display = 'none';
}

function getQueryKeyYear()
{
	if (u1 == "UTPA")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + key + 'return $x/titles }; let $List:= (' + listUTPA + ') for $item in $List return (local:getPapers($item))';		
	}
	else if (u1 == "UTB")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + key + 'return $x/titles }; let $List:= (' + listUTB + ') for $item in $List return (local:getPapers($item))';		
	}
	else if (u1 == "UTEP")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + key + 'return $x/titles }; let $List:= (' + listUTEP + ') for $item in $List return (local:getPapers($item))';		
	}
	else
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + key +'return $x/titles }; let $List:= (' + listUTSA + ') for $item in $List return (local:getPapers($item))';	
	}

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'none';
    document.getElementById("queryLabel2").style.display = 'none';
    document.getElementById("submit2").style.display = 'none';
}

function getQueryYear()
{
	if (u1 == "UTPA")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + listUTPA + ') for $item in $List return (local:getPapers($item))';		
	}
	else if (u1 == "UTB")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + listUTB + ') for $item in $List return (local:getPapers($item))';	
	}
	else if (u1 == "UTEP")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + listUTEP + ') for $item in $List return (local:getPapers($item))';		
	}
	else
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + listUTSA + ') for $item in $List return (local:getPapers($item))';		
	}

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'none';
    document.getElementById("queryLabel2").style.display = 'none';
    document.getElementById("submit2").style.display = 'none';
}
</script>

<script>  // Double Queries
function getDoubleQuery()
{
	if (u1 == "UTPA")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + listUTPA + ') for $item in $List return (local:getPapers($item))';	
	}
	else if (u1 == "UTB")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + listUTB + ') for $item in $List return (local:getPapers($item))';
	}
	else if (u1 == "UTEP")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + listUTEP + ') for $item in $List return (local:getPapers($item))';	
	}
	else 
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + listUTSA + ') for $item in $List return (local:getPapers($item))';	
	}

	
	if (u2 == "UTPA")
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + listUTPA + ') for $item in $List return (local:getPapers($item))';	
	}
	else if (u2 == "UTB")
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + listUTB + ') for $item in $List return (local:getPapers($item))';		
	}
	else if (u2 == "UTEP")
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + listUTEP + ') for $item in $List return (local:getPapers($item))';
	}
	else 
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name return $x/titles }; let $List:= (' + listUTSA + ') for $item in $List return (local:getPapers($item))';		
	}

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'inline';
    document.getElementById("queryLabel2").style.display = 'inline';
    document.getElementById("submit2").style.display = 'inline';	
}

function getDoubleQueryKey()
{
	if (u1 == "UTPA")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + listUTPA + ') for $item in $List return (local:getPapers($item))';		
	}
	else if (u1 == "UTB")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + listUTB + ') for $item in $List return (local:getPapers($item))';		
	}
	else if (u1 == "UTEP")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + listUTEP + ') for $item in $List return (local:getPapers($item))';	
	}
	else
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + listUTSA + ') for $item in $List return (local:getPapers($item))';	
	}

	
	if (u2 == "UTPA")
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + listUTPA + ') for $item in $List return (local:getPapers($item))';		
	}
	else if (u2 == "UTB")
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + listUTB + ') for $item in $List return (local:getPapers($item))';
	}
	else if (u2 == "UTEP")
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + listUTEP + ') for $item in $List return (local:getPapers($item))';		
	}
	else
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + contain + 'return $x/titles }; let $List:= (' + listUTSA + ') for $item in $List return (local:getPapers($item))';
    }

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'inline';
    document.getElementById("queryLabel2").style.display = 'inline';
    document.getElementById("submit2").style.display = 'inline';
}

function getDoubleQueryKeyYear()
{
	if (u1 == "UTPA")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + contain + 'return $x/titles }; let $List:= (' + listUTPA + ') for $item in $List return (local:getPapers($item))';		
	}
	else if (u1 == "UTB")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + contain + 'return $x/titles }; let $List:= (' + listUTB + ') for $item in $List return (local:getPapers($item))';		
	}
	else if (u1 == "UTEP")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + contain + 'return $x/titles }; let $List:= (' + listUTEP + ') for $item in $List return (local:getPapers($item))';	
	}
	else
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + contain +'return $x/titles }; let $List:= (' + listUTSA + ') for $item in $List return (local:getPapers($item))';	
	}

	
	if (u2 == "UTPA")
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + contain + 'return $x/titles }; let $List:= (' + listUTPA + ') for $item in $List return (local:getPapers($item))';
	}
	else if (u2 == "UTB")
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + contain + 'return $x/titles }; let $List:= (' + listUTB + ') for $item in $List return (local:getPapers($item))';	
	}
	else if (u2 == "UTEP")
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + contain + 'return $x/titles }; let $List:= (' + listUTEP + ') for $item in $List return (local:getPapers($item))';		
	}
	else
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + contain +'return $x/titles }; let $List:= (' + listUTSA + ') for $item in $List return (local:getPapers($item))';
    }

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';

    document.getElementById("query2").style.display = 'inline';
    document.getElementById("queryLabel2").style.display = 'inline';
    document.getElementById("submit2").style.display = 'inline';		
}

function getDoubleQueryYear()
{
	if (u1 == "UTPA")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + listUTPA + ') for $item in $List return (local:getPapers($item))';	
	}
	else if (u1 == "UTB")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + listUTB + ') for $item in $List return (local:getPapers($item))';		
	}
	else if (u1 == "UTEP")
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + listUTEP + ') for $item in $List return (local:getPapers($item))';		
	}
	else
	{
		document.getElementById("query").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + listUTSA + ') for $item in $List return (local:getPapers($item))';	
	}

	
	if (u2 == "UTPA")
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + listUTPA + ') for $item in $List return (local:getPapers($item))';	
	}
	else if (u2 == "UTB")
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + listUTB + ') for $item in $List return (local:getPapers($item))';	
	}
	else if (u2 == "UTEP")
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + listUTEP + ') for $item in $List return (local:getPapers($item))';
	}
	else
	{
		document.getElementById("query2").value = 'declare variable $author_name:= 0; declare function local:getPapers($author_name) { for $x in doc("C:/dblpsample.xml")/dblp/article where $x/author = $author_name' + year + 'return $x/titles }; let $List:= (' + listUTSA + ') for $item in $List return (local:getPapers($item))';
	}

    document.getElementById("query").style.display = 'inline';
    document.getElementById("queryLabel").style.display = 'inline';
    document.getElementById("submit1").style.display = 'inline';	

    document.getElementById("query2").style.display = 'inline';
    document.getElementById("queryLabel2").style.display = 'inline';
    document.getElementById("submit2").style.display = 'inline';	
}
</script>


<script>
function getInfo()
{
	getValues();
	
	if (test == 1)
	{
		return;
	}


	if (custom1 == "-" && custom2 == "-") {

        document.getElementById("u1").disabled = false;
	    document.getElementById("u2").disabled = false;

	    if (u1 === "0") {
	        document.getElementById("query").value = "-";
	        alert("Please enter a university in the first field!");
	    }
	    else {
	        if (u2 === "0") {
	            if (key === "-") {
	                if (y1 !== "-" && y2 !== "-") {
	                    getQueryYear();
	                }
	                else {
	                    getQuery();

	                }
	            }
	            else {
	                if (y1 !== "-" && y2 !== "-") {
	                    getQueryKeyYear();
	                }
	                else {
	                    getQueryKey();
	                }
	            }
	        }
	        else {
	            if (key === "-") {
	                if (y1 !== "-" && y2 !== "-") {
	                    getDoubleQueryYear();
	                }
	                else {
	                    getDoubleQuery();
	                }
	            }
	            else {
	                if (y1 !== "-" && y2 !== "-") {
	                    getDoubleQueryKeyYear();
	                }
	                else {
	                    getDoubleQueryKey();
	                }
	            }
	        }
	    }
	}
	else {

	    document.getElementById("u1").disabled = true;
	    document.getElementById("u2").disabled = true;

        if (custom2 === "-") {
	        if (key === "-") {
	            if (y1 !== "-" && y2 !== "-") {
	                getSingleCustomYear();
	            }
	            else {
	                getSingleCustom();

	            }
	        }
	        else {
	            if (y1 !== "-" && y2 !== "-") {
	                getSingleCustomKeyYear();
	            }
	            else {
	                getSingleCustomKey();
	            }
	        }
	    }
	    else {
	        if (key === "-") {
	            if (y1 !== "-" && y2 !== "-") {
	                getDoubleCustomYear();
	            }
	            else {
	                getDoubleCustom();
	            }
	        }
	        else {
	            if (y1 !== "-" && y2 !== "-") {
	                getDoubleCustomKeyYear();
	            }
	            else {
	                getDoubleCustomKey();
	            }
	        }
	    }
	}
}
</script>


<script type="text/javascript" src="jquery.js"></script>

<script type="text/javascript">
       $(document).ready(function(){
          $("#submit1").click(function(){
            $.post("result1.php", {query: $("#query").val(), u1: $("#u1").val()}, function(data){
              $("#result").html(data);
            });
          })
       })
      </script>

<script type="text/javascript">
       $(document).ready(function(){
          $("#submit2").click(function(){
            $.post("result2.php", {query2: $("#query2").val(), u2: $("#u2").val()}, function(data){
              $("#result2").html(data);
            });
          })
       })
      </script>

</br>
<div id="result"> <p>Query result will be displayed here</p> </div> </br>

<div id="result2"> <p>Query 2 result will be displayed here</p> </div>


</br>
<form action="graph.php" method="post"> 
<input type="submit" value="Show Graph">
</form>


<script>
function displayArray()
{
	//takes array from variables2.php and stores it in "myvar"
	<?php include ("variables2.php"); ?>
	myvar = <?php echo json_encode($arrayUpdate); ?>;
	
	
	//Takes "myvar" and removes duplicate elements.  Stores the result in "uniqueTitles"
	var uniqueTitles = [];
	$.each(myvar, function(i, el){
		if($.inArray(el, uniqueTitles) === -1) uniqueTitles.push(el);
	});
	
	
	//Combines every element of "uniqueTitles" into a string named "fullList"
	var fullList = "";
	
	for (var p = 0; p < uniqueTitles.length; p++)
	{
		fullList = fullList.concat(uniqueTitles[p]);
		fullList = fullList.concat(" ");
	}
	
	
	//list of terms to be removed from "fullList".  These terms will be replaced by "" or " "
	var mapObj = 
	{
		'<titles>':"",
		'</titles>':"",
		' The ':" ",
		' the ':" ",
		' Of ':" ",
		' of ':" ",
		' From ':" ",
		' from ':" ",
		' And ':" ",
		' and ':" ",
		' With ':" ",
		' with ':" ",
		' In ':" ",
		' in ':" ",
		' an ':" ",
		' An ':" ",
		' Their ':" ",
		' their ':" ",
		' For ':" ",
		' for ':" ",
		' On ':" ",
		' on ':" ",
		' Using ':" ",
		' using ':" ",
		' A ':" ",
		' a ':" ",
		' Through ':" ",
		' through ':" ",
		' Report ':" ",
		' report ':" ",
		' Reports ':" ",
		' reports ':" ",
		' To ':" ",
		' to ':" ",
		' By ':" ",
		' by ':" ",
		' Are ':" ",
		' are ':" ",
		' One ':" ",
		' one ':" ",
		' Two ':" ",
		' two ':" ",
		' Both ':" ",
		' both ':" ",
		' Some ':" ",
		' some ':" ",
		' View ':" ",
		' view ':" ",
		' Views ':" ",
		' views ':" ",
		' Scientific ':" ",
		' scientific ':" ",
		' Approach ':" ",
		' approach ':" ",
	};
	
	
	//Removes these terms from "fullList".  The process is repeated three times followed by a statement that removes puncation (besides "-")
	fullList = fullList.replace(/<titles>|<\/titles>| The | the | Of | of | From | from | And | and | With | with | In | in | An | an | Their | their | For | for | On | on | Using | using | A | a | Through | through | Report | report | Reports | reports | To | to | By | by | Are | are | One | one | Two | two | Both | both | Some | some | View | view | Views | views | Scientific | scientific | Approach | approach /gi, function(matched){
			return mapObj[matched];
			});
	fullList = fullList.replace(/<titles>|<\/titles>| The | the | Of | of | From | from | And | and | With | with | In | in | An | an | Their | their | For | for | On | on | Using | using | A | a | Through | through | Report | report | Reports | reports | To | to | By | by | Are | are | One | one | Two | two | Both | both | Some | some | View | view | Views | views | Scientific | scientific | Approach | approach /gi, function(matched){
			return mapObj[matched];
			});
	fullList = fullList.replace(/<titles>|<\/titles>| The | the | Of | of | From | from | And | and | With | with | In | in | An | an | Their | their | For | for | On | on | Using | using | A | a | Through | through | Report | report | Reports | reports | To | to | By | by | Are | are | One | one | Two | two | Both | both | Some | some | View | view | Views | views | Scientific | scientific | Approach | approach /gi, function(matched){
			return mapObj[matched];
			});
	fullList = fullList.replace(/[\.,\/#!$%\^&\*;:{}=\_`~()]/g,"")
	
	
	//Stores the most common words in "fullList" and stores them in "Top Words"
	var wordRegExp = /\w+(?:'\w{1,2})?/g;
    var words = {};
    var matches;
    while ((matches = wordRegExp.exec(fullList)) != null)
    {
        var word = matches[0].toLowerCase();
        if (typeof words[word] == "undefined")
        {
            words[word] = 1;
        }
        else
        {
            words[word]++;
        }
    }

    var wordList = [];
    for (var word in words)
    {
        if (words.hasOwnProperty(word))
        {
            wordList.push([word, words[word]]);
        }
    }
    wordList.sort(function(a, b) { return b[1] - a[1]; });

    var topWords = [];
    for (var i = 0; i < wordList.length; i++)
    {
        topWords.push(wordList[i][0]);
		topWords.push("<br>");
    }
	
	
	var newWindow = window.open();
	newWindow.document.write(topWords);
}
</script>

<button onclick= "displayArray()">Display</button></br></br>

</body>
</html>