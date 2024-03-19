<div class="modal fade" id="modal-show-currcency" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centereds modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Symbol Search</h4>
                <button type="button" class="close mr-2 btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">

                <div class="input-group custom-search-area">
                    <span class="input-group-text">
                        <a href="javascript:void(0)">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.5605 18.4395L16.7527 14.6317C17.5395 13.446 18 12.0262 18 10.5C18 6.3645 14.6355 3 10.5 3C6.3645 3 3 6.3645 3 10.5C3 14.6355 6.3645 18 10.5 18C12.0262 18 13.446 17.5395 14.6317 16.7527L18.4395 20.5605C19.0245 21.1462 19.9755 21.1462 20.5605 20.5605C21.1462 19.9747 21.1462 19.0252 20.5605 18.4395V18.4395ZM5.25 10.5C5.25 7.605 7.605 5.25 10.5 5.25C13.395 5.25 15.75 7.605 15.75 10.5C15.75 13.395 13.395 15.75 10.5 15.75C7.605 15.75 5.25 13.395 5.25 10.5V10.5Z" fill="var(--primary)"></path>
                            </svg>
                        </a>
                    </span>
                    <input type="text" class="form-control border-start-0 w-searching" placeholder="Search here...">
                </div>

                <div class="col-xl-12 my-order-ile">
                    <div class="card">
                        <div class="card-header border-0 pb-3">
                            <h4 class="card-title">Market Previews</h4>
                        </div>
                        <div style="display: none;">
                            <div class="d-flex justify-content-between align-items-center market-preview card-wallet">
                                <div class="d-flex align-items-center">
                                    <span>

                                        <img class="v-logo" height="30px" width="30px" src="https://assets.coingecko.com/coins/images/1/large/bitcoin.png?1696501400" alt="">

                                    </span>
                                    <div class="ms-3">
                                        <a href="javascript:void(0);">
                                            <h5 class="fs-14 font-w600 mb-0 text-uppercase"><span class="v-currcency">BTC</span>/USTD</h5>
                                        </a>
                                        <span class="fs-12 font-w400 v-currcency-name">
                                            Bitcoin
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="ms-3" style="text-align: end;">
                                        <h5 class="fs-14 font-w600 v-price text-success text-right">0.00</h5>
                                        <span class="text-danger v-percent">0,0</span>
                                        <!-- <span>%</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body px-0 pt-0 dlab-scroll height400 contacts-list">

                        </div>
                    </div>
                </div>

            </div>
            <div class="footers m-2">
                <button class="btn btn-secondary btn-block" data-bs-dismiss="modal" aria-label="Close">
                    Choose Trade Now
                </button>
            </div>
        </div>
    </div>
</div>