<h2>Search Clients</h2>
<form action="contacts.php" enctype="multipart/form-data" method="post">
    <input name="itemNumberIndex" class="text" type="hidden" >
    <fieldset>
        
        <legend></legend>
        <ol>
                
            <li>
                <label for="name1">First Name:</label>
                <input id="name1" name="name1" class="text" type="text" >
            </li>
            <li>
                <label for="name2">Last Name:</label>
                <input id="name2" name="name2" class="text" type="text" >
            </li>
            <li>
                <label for="email">Email:</label>
                <input id="email" name="email" class="text" type="text" >
            </li>
            <li>
                <label for="phone">Phone:</label>
                <input id="phone" name="phone1" class="text" type="text" size="3" >
                <input  name="phone2" class="text" type="text" size="3" >
                <input  name="phone3" class="text" type="text" size="4" >
            </li>
            <li>
                <input name="phone4" class="text" type="hidden" size="3" >
                <input name="phone5" class="text" type="hidden" size="3" >
                <input name="phone6" class="text" type="hidden" size="4" >
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
         <legend></legend>
        <input class="submit" type="submit" value="Search" >
    </fieldset>
</form>