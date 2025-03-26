<div>
    <x-slot name="header">State</x-slot>
    <x-aaran-ui::forms.m-panel>
        <x-aaran-ui::alerts.notification />


        <!-- Top Controls --------------------------------------------------------------------------------------------->
        <x-aaran-ui::forms.top-controls :show-filters="$showFilters"/>

        <!-- Table Caption -------------------------------------------------------------------------------------------->
        <x-aaran-ui::table.caption :caption="'State'">
            {{$list->count()}}
        </x-aaran-ui::table.caption>

        <!-- Table Data ----------------------------------------------------------------------------------------------->

        <x-aaran-ui::table.form>
            <x-slot:table_header>
                <x-aaran-ui::table.header-serial/>
                <x-aaran-ui::table.header-text wire:click.prevent="sortBy('id')" sortIcon="{{$sortAsc}}" :left="true">
                    Name
                </x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text> State Code</x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-status/>
                <x-aaran-ui::table.header-action/>
            </x-slot:table_header>

            <x-slot:table_body>
                @foreach($list as $index=>$row)
                    <x-aaran-ui::table.row>
                        <x-aaran-ui::table.cell-text>{{$index+1}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text left>{{$row->vname}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text>{{$row->state_code}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-status active="{{$row->active_id}}"/>
                        <x-aaran-ui::table.cell-action id="{{$row->id}}"/>
                    </x-aaran-ui::table.row>
                @endforeach
            </x-slot:table_body>
        </x-aaran-ui::table.form>

        <!-- Delete Modal --------------------------------------------------------------------------------------------->
        <x-aaran-ui::modal.delete/>

        <div class="pt-5">{{ $list->links() }}</div>

        <!-- Create/ Edit Popup --------------------------------------------------------------------------------------->

        <x-aaran-ui::forms.create :id="$vid">
            <div class="flex flex-col  gap-3">
                <x-aaran-ui::input.floating wire:model="vname" label="State Name"/>
                <x-aaran-ui::input.error-text wire:model="vname"/>
                <x-aaran-ui::input.floating wire:model="state_code" label="State Code"/>
            </div>
        </x-aaran-ui::forms.create>


    </x-aaran-ui::forms.m-panel>
</div>
