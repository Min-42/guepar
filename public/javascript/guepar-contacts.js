var $collectionHolder;

// Préparation du lien "ajouter un contact"
var $addContactButton = $('<button type="button" class="add_contact_link btn btn-sm btn-primary">Ajouter un contact</button>');
var $newLinkLi = $('<li></li>').append($addContactButton);

$(function() {
    // Récupère l'ul qui contient la collections de contacts
    $collectionHolder = $('ul.ulContacts');

    // pour chaque contact : bouton édit, bouton suppression, affichage en texte et champs cachés
    $collectionHolder.find('li').each(function() {
        addContactFormDeleteLink($(this));
        addContactFormEditLink($(this));
        toggleEditFields($(this));
    });

    // Ajout du bouton "Ajouter un contact"
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have use that as the new
    // index when inserting a new item
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addContactButton.on('click', function(e) {
        // add a new contact form (see next code block)
        addContactForm($collectionHolder, $newLinkLi);
    });
});

function addContactForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Ajouter un contact" link li
    var $newFormLi = $('<li></li>').append(newForm);
    addContactFormDeleteLink($newFormLi);
    $newLinkLi.before($newFormLi);
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
    var $editFormButton = $('<a href"#"><img src="/images/ico-edit.ico" class="ico-edit"></a>');
    $contactFormLi.prepend($editFormButton);

    $editFormButton.on('click', function(e) {
        toggleEditFields($contactFormLi);
    });
}

function addContactValues($contactFormLi) {
    var contactValue = "";
    $contactFormLi.find(':input').each(function(index) {
        if (index == 0) contactValue += $(this).val();
        if (index == 1) contactValue += " "+$(this).val();
        if (index == 2) contactValue += " "+$(this).val();
        if (index == 3) contactValue += " - Fct : "+$(this).val();
        if (index == 4) contactValue += " - email : "+$(this).val();
        if (index == 5) contactValue += " - tel : "+$(this).val();
        if (index == 6) contactValue += " - notes : "+$(this).val();
    });
    $contactFormLi.find('#valeursContact').html(contactValue);
}

function toggleEditFields($contactFormLi, edit=false) {
    $contactFormLi.find('div').each(function() {
        $(this).toggle();
    });
    addContactValues($contactFormLi)
}