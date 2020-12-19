/* eslint no-undef: */

class MSPPP {
  constructor () {
    this._count = 0
    this.selectBlockId = 'mspPrivateParts_count'
    this.selectCountName = 'mspPrivateParts_count_select'
    this.printCountId = 'mspPrivateParts_count_print'
    this.printMonthlyId = 'mspPrivateParts_count_monthly_print'
    this.toggleSelect = (display = 'block') => {
      const selectElements = document.getElementById(this.selectBlockId)
      selectElements.style.display = display
    }
    this.showSelect = () => this.toggleSelect('block')
    this.hideSelect = () => this.toggleSelect('none')
    this.ms2PaymentFieldCallback = (response) => {
      // console.log(response)
      if ('payment' in response.data) {
        console.log(mspppConfig.payments, parseInt(response.data.payment), response.data.payment, mspppConfig.payments.indexOf(parseInt(response.data.payment)))
        if (mspppConfig.payments.indexOf(parseInt(response.data.payment)) !== -1) this.showSelect()
        else this.hideSelect()
      }
    }
    this.ms2PaymentGetCostCallback = (response) => {
      const cost = response.data.cost
      const monthly = Math.floor(cost / this.count)
      const printCount = document.getElementById(this.printCountId)
      const printMonthly = document.getElementById(this.printMonthlyId)
      if (printCount) printCount.innerHTML = String(this.count)
      if (printMonthly) printMonthly.innerHTML = String(miniShop2.Utils.formatPrice(monthly))
    }
  }

  get count () {
    if (this._count === 0) this._count = mspppConfig.count
    return this._count
  }

  set count (count) {
    this._count = count
  }
}

const msppp = new MSPPP()

// eslint-disable-next-line no-undef
miniShop2.Callbacks.add('Order.add.response.success', 'mspppPaymentCheck', msppp.ms2PaymentFieldCallback)
miniShop2.Callbacks.add('Order.getcost.response.success', 'mspppPaymentGetCost', msppp.ms2PaymentGetCostCallback)
if (mspppConfig.show) {
  msppp.showSelect()
}

/** @type {function} */
$(document).on('change', '#' + msppp.selectCountName, function (e) {
  msppp.count = parseInt($(e.target).val())
  miniShop2.Order.getcost()
})
