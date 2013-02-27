<?php
$contacts = Contact::find_all();
?>
<?php echo $session->message(); ?>
<div class="box">
    <table id="contact_list" border="0" width="100%" cellpadding="10">
        <tr>
        </tr>
        <?php foreach($contacts as $contact) : ?>

        <tr>
            <td><a href="contact.php?id=<?php echo $contact->id; ?>"><?php echo $contact->full_name(); ?></a></td>
            <td><a href="contact_delete.php?contactID=<?php echo $contact->id; ?>">Delete</a></td>
        </tr>

        <?php endforeach;?>
    </table>
</div> <!--box-->