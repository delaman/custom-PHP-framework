<center><h1>Work Order</h1></center><br>

<form action="item_insert.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="team">Team:</label>
                <input id="team" name="team" class="text" type="text" />
            </li>
            <li>
                <label for="date">Date:</label>
                <input id="date" name="date" class="text" type="text" />
            </li>
        </ol>
    </fieldset>

    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="pickup">Pickup:</label>
                <input id="pickup" name="pickup" class="text" type="text" />
            </li>
            <!--
            <li>
                <label for="time">Time:</label>
                <input id="time" name="time" class="text" type="text" size="5" />
            </li>
            -->
            <li>
                <label for="artLocation">Art Location:</label>
                <select id="artLocation" name="artLocation">
                    <option disabled>Select One</option>
                    <option value="tyArtTemp">TYart Temp</option>
                    <option value="worksOnSite">Works on site</option>
                </select>
            </li>
        </ol>
    </fieldset>

    <fieldset>
        <legend>Job Time Window:</legend>
        <ol>
            <li>
                <label for="jobTimeStart">Start:</label>
                <select id="jobTimeStart" name="jobTimeStartHour">
                    <option disabled>Hour</option>
                    <?php for($i = 1; $i <=12; $i++) : ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
                <select id="jobTimeStart" name="jobTimeStartMinute">
                    <option disabled>Minute</option>
                    <?php for($i = 0; $i <60; $i=$i+5) : ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
                <select id="jobTimeStart" name="jobTimeStartAMPM">
                    <option disabled>AM/PM</option>
                    <option value="am">AM</option>
                    <option value="pm">PM</option>
                </select>
            </li>
            <li>
                <label for="jobTimeEnd">End:</label>
                <select id="jobTimeEnd" name="jobTimeEndHour">
                    <option disabled>Hour</option>
                    <?php for($i = 1; $i <=12; $i++) : ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
                <select id="jobTimeEnd" name="jobTimeEndMinute">
                    <option disabled>Minute</option>
                    <?php for($i = 0; $i <60; $i=$i+5) : ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
                <select id="jobTimeEnd" name="jobTimeEndAMPM">
                    <option disabled>AM/PM</option>
                    <option value="am">AM</option>
                    <option value="pm">PM</option>
                </select>
            </li>
        </ol>
    </fieldset>

    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="delivery">Delivery:</label>
                <select id="delivery" name="delivery">
                    <option disabled>Select One</option>
                    <option value="pickUpOnly">Pick Up Only</option>
                    <option value="deliveryOnly">Delivery Only</option>
                </select>
            </li>
        </ol>
    </fieldset>

    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="typeOfWork">Type of Work:</label>
                <select id="typeOfWork" name="typeOfWork">
                    <option disabled>Select One</option>
                    <option value="canvases">Canvas(es)</option>
                    <option value="framedGlazedWorks">Framed/Glazed Work(s)</option>
                    <option value="sculptures">Sculpture(s)</option>
                    <option value="other">Other</option>
                </select>
                <input id="typeOfWork" name="typeOfWorkText" class="text" type="text"/>
            </li>
        </ol>
    </fieldset>

    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="installationSpecification">Installation Specifications:</label>
                <select id="installationSpecification" name="installationSpecification">
                    <option disabled>Select One</option>
                    <option value="indoor">Indoor</option>
                    <option value="outdoor">Outdoor</option>
                    <option value="gallery">Gallery</option>
                    <option value="residence">Residence</option>
                    <option value="office">Office</option>
                    <option value="other">Other</option>
                </select>
            </li>
        </ol>
    </fieldset>

    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="material">Material:</label>
                <select id="material" name="material">
                    <option disabled>Select One</option>
                    <option value="sheetrock">Sheetrock</option>
                    <option value="brickStucco">Brick/Stucco</option>
                    <option value="fabric">Fabric</option>
                    <option value="plaster">Plaster</option>
                    <option value="paneling">Paneling</option>
                    <option value="other">Other</option>
                </select>
            </li>
        </ol>
    </fieldset>

    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="material2">:</label>
                <select id="material2" name="material2">
                    <option disabled>Select One</option>
                    <option value="ladders">Ladder(s)</option>
                    <option value="obstacles/obstructions">Obstacles/Obstructions</option>
                    <option value="stairs">Stairs</option>
                    <option value="elevator">Elevator</option>
                    <option value="security">Security</option>
                    <option value="suspension">Suspension</option>
                    <option value="heavyTogglebolts">Heavy/Togglebolts</option>
                    <option value="siteVisit">Site Visit</option>
                </select>
                <input id="material2" name="material2Text" class="text" type="text"/>
            </li>
        </ol>
    </fieldset>

    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="specialInstructions">Special Instructions:</label>
                <textarea id="specialInstructions" rows="10" cols="50" name="specialInstructions"></textarea>
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submit" value="Insert" />
    </fieldset>
</form>