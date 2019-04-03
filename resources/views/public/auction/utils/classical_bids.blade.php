@if(Auth::check() && $user->bids->count())
    <div class="result_of_bids type_b"
         id="table_nav"
         data-table="{{ json_encode([
                                         'personal_bid_limit' => $auction->personal_bid_limit,
                                         'user_bids'          => $user->bids->count(),
                                         'per_page'           => 10
                                     ]) }}">
        <div class="count">{{ $user->bids->count() }}/{{ $auction->personal_bid_limit }}</div>

        <div class="table_nav_content">
            @foreach($user->bids as $bid)
                <div class="table_item">
                    <div class="item" data-number="1">{{ $bid->created_at->format('d.m.Y') }} <span>{{ $bid->created_at->format('H:i') }}</span></div>
                    <div class="item" data-number="2">{{ $bid->price }} {{ \Constant::get('LEI') }}</div>
                </div>
            @endforeach
        </div>

        <!---- Обрати внимание что последний элемент имеет класс "last" -->

        <div class="pagination">
            <a href="#" class="arrow_l" onclick="TableNav.prev(); return false;">
                <i></i>
            </a>
            <span class="item_per_page"></span>
            <a href="#" class="arrow_r" onclick="TableNav.next(); return false;">
                <i></i>
            </a>
        </div>
    </div>
@endif