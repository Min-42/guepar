var $collectionContactHolder;

// Préparation du lien "ajouter un contact"
var $addContactButton = $('<button type="button" class="add_contact_link btn btn-sm btn-primary">Ajouter un contact</button>');
var $newContactLinkLi = $('<li></li>').append($addContactButton);

$(function() {
    // Récupère l'ul qui contient la collections de contacts
    $collectionContactHolder = $('ul.ulContacts');

    // pour chaque contact : bouton édit, bouton suppression, affichage en texte et champs cachés
    $collectionContactHolder.find('li').each(function() {
        addContactFormDeleteLink($(this));
        addContactFormEditLink($(this));
        toggleContactEditFields($(this));
    });

    // Ajout du bouton "Ajouter un contact"
    $collectionContactHolder.append($newContactLinkLi);

    // count the current form inputs we have use that as the new
    // index when inserting a new item
    $collectionContactHolder.data('index', $collectionContactHolder.find(':input').length);

    $addContactButton.on('click', function(e) {
        // add a new contact form (see next code block)
        addContactForm($collectionContactHolder, $newContactLinkLi);
    });
});

function addContactForm($collectionContactHolder, $newContactLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionContactHolder.data('prototype');

    // get the new index
    var index = $collectionContactHolder.data('index');

    var newFormContact = prototype;

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newFormContact = newFormContact.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionContactHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Ajouter un contact" link li
    var $newFormContactLi = $('<li></li>').append(newFormContact);
    addContactFormDeleteLink($newFormContactLi);
    $newContactLinkLi.before($newFormContactLi);
}

function addContactFormDeleteLink($contactFormLi) {
    var $removeFormButton = $('<a href"#"><img src="/images/ico-suppress.png" class="ico-suppress"></a><span id="valeursContact"></span>');
    $contactFormLi.prepend($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the contact form
        $contactFormLi.remove();
    });
}

function addContactFormEditLink($contactFormLi) {
    var $contactFormButton = $('<a href"#"><img src="/images/ico-edit.ico" class="ico-edit"></a>');
    $contactFormLi.prepend($contactFormButton);

    $contactFormButton.on('click', function(e) {
        toggleContactEditFields($contactFormLi);
    });
}

function addContactValues($contactFormLi) {
    var contactValue = "";
    $contactFormLi.find(':input').each(function(index) {
        if (index == 0) contactValue += $(this).val();
        if (index == 1) contactValue += " "+$(this).val();
        if (index == 2) contactValue += " "+$(this).val();
        if (index == 3 && $(this).val()!= "") contactValue += "<br>&nbsp;&nbsp;&nbsp;Fonction : "+$(this).val();
        if (index == 4 && $(this).val()!= "") contactValue += "<br>&nbsp;&nbsp;&nbsp;Email : "+$(this).val();
        if (index == 5 && $(this).val()!= "") contactValue += "<br>&nbsp;&nbsp;&nbsp;Téléphone : "+$(this).val();
        if (index == 6 && $(this).val()!= "") contactValue += "<br>&nbsp;&nbsp;&nbsp;Notes : "+$(this).val();
    });
    $contactFormLi.find('#valeursContact').html(contactValue);
}

function toggleContactEditFields($contactFormLi, edit=false) {
    $contactFormLi.find('div').each(function() {
        $(this).toggle();
    });
    addContactValues($contactFormLi)
}