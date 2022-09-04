import {reactive} from 'vue'

export const deliveryAddressStore = reactive({
    selectedAddress: {},
    addresses: [],
    editingAddressIndex: '',
    isNewAddress: false,
    isEditAddress: false,

    editAddress(index) {
        this.editingAddressIndex = index
        this.isEditAddress = true
    },
})
