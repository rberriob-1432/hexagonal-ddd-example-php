/**
 * Solicita confirmación antes de enviar un formulario de eliminación.
 *
 * @param {HTMLFormElement} form
 * @returns {boolean}
 */
function confirmDelete(form) {
    var name = form.getAttribute('data-name') || 'este elemento';
    var entity = form.getAttribute('data-entity') || 'registro';

    return confirm('¿Eliminar ' + entity + ' "' + name + '"?');
}