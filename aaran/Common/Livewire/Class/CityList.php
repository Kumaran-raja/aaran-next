<?php

namespace Aaran\Common\Livewire\Class;

use Aaran\Assets\Trait\CommonTrait;
use Aaran\Common\Models\City;
use Aaran\Core\Tenant\Facades\TenantSwitch;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CityList extends Component
{
    use CommonTrait;

    #[Validate]
    public string $vname = '';
    public bool $active_id = true;

    #region[Validation]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : '|unique:cities,vname'),
        ];
    }

    public function messages(): array
    {
        return [
            'vname.required' => ':attribute is missing.',
            'vname.unique' => 'This :attribute is already created.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'vname' => 'city name',
        ];
    }

    #endregion[Validation]

    #region[getSave]
    public function getSave(): void
    {
        $this->validate();

        if ($this->vid == "") {

            TenantSwitch::set();

            dd(config('database.default'));

            City::on('tenant')->create([
                'vname' => Str::ucfirst($this->vname),
                'active_id' => $this->active_id,
            ]);
            $message = "Saved";

        } else {
            $obj = City::on('tenant')->find($this->vid);
            $obj->vname = Str::ucfirst($this->vname);
            $obj->active_id = $this->active_id;
            $obj->save();
            $message = "Updated";
        }

        $this->dispatch('notify', ...['type' => 'success', 'content' => $message . ' Successfully']);
    }
    #endregion

    #region[Clear Fields]
    public function clearFields(): void
    {
        $this->vid = '';
        $this->vname = '';
        $this->active_id = '1';
        $this->searches = '';
    }
    #endregion[Clear Fields]

    #region[getObj]
    public function getObj($id): void
    {
        if ($id) {
            $obj = City::on('tenant')->find($id);
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->active_id = $obj->active_id;
        }
    }
    #endregion

    #region[getList]
    public function getList()
    {
//        $databaseName = config("database.connections." . config('database.default') . ".database");
//        dd($databaseName);

        return City::on('tenant')
            ->where('active_id', '=', $this->activeRecord)
            ->when($this->searches, fn($query) => $query->where('vname', 'like', "%{$this->searches}%"))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }
    #endregion

    #region[delete]
    public function deleteFunction($id): void
    {
        if ($id) {
            $obj = City::on('tenant')->find($id);
            if ($obj) {
                $obj->delete();
                $message = "Deleted Successfully";
                $this->dispatch('notify', ...['type' => 'success', 'content' => $message]);
            }
        }
    }
    #endregion

    #region[render]
    public function render()
    {
        return view('common::city-list')->with([
            'list' => $this->getList()
        ]);
    }
    #endregion
}
