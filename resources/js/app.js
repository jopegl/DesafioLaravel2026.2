import './bootstrap';

import Alpine from 'alpinejs';

import crudModals from './alpine/crud-modals';
import cepAddressForm from './alpine/cep-address-form';
import addressModals from './alpine/address-modals';
import emailSearch from './alpine/email-search';

window.Alpine = Alpine;

Alpine.data('crudModals', crudModals);
Alpine.data('cepAddressForm', cepAddressForm);
Alpine.data('addressModals', addressModals);
Alpine.data('emailSearch', emailSearch);

Alpine.start();
