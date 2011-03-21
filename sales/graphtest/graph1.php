<html>

<head>
<title>Graph Test</title>

<script type="text/javascript">
function createGraph() {

        // which form ?
        formIndex = 0;
        for (i=0;i<document.forms.length;i++) {
                if (document.forms[i].name == "plotGraph") {
                        formIndex = i;
                }
        }

        // get all the values from the form
        selectbox = document.forms[formIndex].year;
        year = selectbox.options[selectbox.selectedIndex].value;

        // new image tag
        newcontent  = '<img src="http://hf01sql/csPortal_dev/sales/jpowered/graph/vertical-cylinder-graph.php?';
        newcontent += 'datascript=http://hf01sql/csPortal_dev/sales/graphtest/datafunction.php&';
        newcontent += 'config=http://hf01sql/csPortal_dev/sales/graphtest/config.php&';
        newcontent += 'year='+year+'"';
        newcontent += 'width=800';
        newcontent += 'height=400>';

        document.getElementById("graphContent").innerHTML = newcontent;

        // return false to stop the 'normal' form submission
        // process and prevent the whole page being refreshed
        return false;
}
</script>
</head>

<body>

<form id="plotGraph" name="plotGraph" method="post" onsubmit="return createGraph();" action="">
Select Year
<select name="year" class="selectfield">
        <option value="2006">2006</option>
        <option value="2007">2007</option>
        <option value="2008">2008</option>
</select>
<input name="submit" value="Create Graph" type="submit">

</form>

<br><bR>

<div id="graphContent">
<img src="http://hf01sql/csPortal_dev/sales/jpowered/graph/vertical-cylinder-graph.php?
datascript=http://hf01sql/csPortal_dev/sales/graphtest/datafunction.php&
config=http://hf01sql/csPortal_dev/sales/graphtest/config.php&
year=2008"
width=800
height=400>
</div>

</body>

</html>

