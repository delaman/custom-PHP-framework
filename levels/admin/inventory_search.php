<h2>Search Inventory</h2>
<form action="inventory_list.php" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="itemNumber">Item Number:</label>
                <input id="itemNumber" name="itemNumber" class="text" type="text" />
            </li>
            <li>
                <label for="artist">Artist:</label>
                <input id="artist" name="artist" class="text" type="text" />
            </li>
            <li>
                <label for="title">Title:</label>
                <input id="title" name="title" class="text" type="text" />
            </li>
            <li>
                <label for="medium">Medium:</label>
                <input id="medium" name="medium" class="text" type="text" />
            </li>
            <li>
                <label for="building">Building:</label>
                <input id="building" name="building" class="text" type="text" />
            </li>
            <li>
                <label for="aisle">Aisle:</label>
                <input id="aisle" name="aisle" class="text" type="text" />
            </li>
            <li>
                <label for="section">Section:</label>
                <input id="section" name="section" class="text" type="text" />
            </li>
            <li>
                <label for="number">Number:</label>
                <input id="number" name="number" class="text" type="text" />
            </li>
            <!--hidden-->
            <input name="id" class="text" type="hidden" />
            <input name="inInventory" class="text" type="hidden" />
            <input name="lengthSign"  type="hidden"/>
            <input id="dimension" name="length" class="text" type="hidden" size="4" />
            <input name="widthSign"  type="hidden"/>
            <input id="dimension" name="width" class="text" type="hidden" size="4" />
            <input name="heightSign"  type="hidden"/>
            <input id="dimension" name="height" class="text" type="hidden" size="4" />
            <input name="lengthSign"  type="hidden"/>
            <input id="dimension" name="lengthPacked" class="text" type="hidden" />
            <input name="widthSign"  type="hidden"/>
            <input id="dimension" name="widthPacked" class="text" type="hidden" />
            <input name="heightSign"  type="hidden"/>
            <input id="dimension" name="heightPacked" class="text" type="hidden" />
            <input id="value" name="value" class="text" type="hidden" size="6" />
            <input  id="insuredBy" name="insuredBy" class="text" type="hidden" />
            <input id="contactID" name="contactID" class="text" type="hidden" />
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" value="Search" />
    </fieldset>
</form>