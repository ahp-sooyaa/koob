import moment from 'moment'

export default {
    methods: {
        formatPrice(price) {
            return (price / 100).toLocaleString('en-US', {style: 'currency', currency: 'USD'})
        },

        formatDate(date) {
            return moment(date).format('MMM D, Y')
        }
    }
}