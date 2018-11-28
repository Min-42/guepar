var $collectionHolder;

// setup an "ajouter un contact" link
var $addContactButton = $('<button type="button" class="add_contact_link btn btn-primary">Ajouter un contact</button>');
var $newLinkLi = $('<li></li>').append($addContactButton);

$(function() {
    // Get the ul that holds the collection of contacts
    $collectionHolder = $('ul.ulContacts');

    // add a delete link to all of the existing contact form li elements
    $collectionHolder.find('li').each(function() {
        addContactFormDeleteLink($(this));
    });

    // add the "ajouter un contact" anchor and li to the contacts ul
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
    $newLinkLi.before($newFormLi);
}

function addContactFormDeleteLink($contactFormLi) {
    var $removeFormButton = $('<button type="button" class="btn btn-primary">Supprimer ce contact</button>');
    $contactFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the contact form
        $contactFormLi.remove();
    });
}