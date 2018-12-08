var $collectionDocumentHolder;

// Préparation du lien "ajouter un document"
var $addDocumentButton = $('<button type="button" class="add_document_link btn btn-sm btn-primary">Ajouter un document</button>');
var $newDocumentLinkLi = $('<li></li>').append($addDocumentButton);

$(function() {
    // Récupère l'ul qui contient la collections de documents
    $collectionDocumentHolder = $('ul.ulDocuments');

    // pour chaque document : bouton édit, bouton suppression, affichage en texte et champs cachés
    $collectionDocumentHolder.find('li').each(function() {
        addDocumentFormDeleteLink($(this));
        addDocumentFormEditLink($(this));
        toggleDocumentEditFields($(this));
    });

    // Ajout du bouton "Ajouter un document"
    $collectionDocumentHolder.append($newDocumentLinkLi);

    // count the current form inputs we have use that as the new
    // index when inserting a new item
    $collectionDocumentHolder.data('index', $collectionDocumentHolder.find(':input').length);

    $addDocumentButton.on('click', function(e) {
        // add a new document form (see next code block)
        addDocumentForm($collectionDocumentHolder, $newDocumentLinkLi);
    });
});

function addDocumentForm($collectionDocumentHolder, $newDocumentLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionDocumentHolder.data('prototype');

    // get the new index
    var index = $collectionDocumentHolder.data('index');

    var newFormDocument = prototype;

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newFormDocument = newFormDocument.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionDocumentHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Ajouter un document" link li
    var $newFormDocumentLi = $('<li></li>').append(newFormDocument);
    addDocumentFormDeleteLink($newFormDocumentLi);
    $newDocumentLinkLi.before($newFormDocumentLi);
}

function addDocumentFormDeleteLink($documentFormLi) {
    var $removeDocumentFormButton = $('<a href"#"><img src="/images/ico-suppress.png" class="ico-suppress"></a>');
    var $spanDocumentValue = $('<span id="valeursDocument"></span>');

    $documentFormLi.prepend($spanDocumentValue);
    $documentFormLi.prepend($removeDocumentFormButton);

    $removeDocumentFormButton.on('click', function(e) {
        if (confirm("Voulez-vous réellement supprimer le document ?")) {
            $documentFormLi.remove();
        }
    });
}

function addDocumentFormEditLink($documentFormLi) {
    var $documentFormButton = $('<a href"#"><img src="/images/ico-edit.ico" class="ico-edit"></a>');
    $documentFormLi.prepend($documentFormButton);

    $documentFormButton.on('click', function(e) {
        toggleDocumentEditFields($documentFormLi);
    });
}

function addDocumentValues($documentFormLi) {
    var categorieDocument = $documentFormLi.find(':input').first().val();
    var lienDocument = $documentFormLi.find('.lienDocument').text();
    var documentValue = '<a href="'+lienDocument+'" target="_blank">'+categorieDocument+'</a>';
    $documentFormLi.find('#valeursDocument').html(documentValue);
}

function toggleDocumentEditFields($documentFormLi, edit=false) {
    $documentFormLi.find('div').each(function() {
        $(this).toggle();
    });
    addDocumentValues($documentFormLi)
}