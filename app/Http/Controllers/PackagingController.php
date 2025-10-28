<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackagingRequest;
use App\Models\Packaging;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PackagingController extends Controller
{
  public function index()
  {
    $packagings = Packaging::orderBy('id', 'ASC')->paginate(10);

    Log::info('Listar as embalagens.', ['action_user_id' => Auth::id()]);

    return view('packagings.index', ['packagings' => $packagings]);
  }

  public function show(Packaging $packaging)
  {
    Log::info('Visualizar a embalagem.', ['packaging_id' => $packaging->id, 'action_user_id' => Auth::id()]);

    return view('packagings.show', ['packaging' => $packaging]);
  }

  public function create()
  {
    return view('packagings.create');
  }

  public function store(PackagingRequest $request)
  {
    try {
      $packaging = Packaging::create([
        'name' => $request->name,
        'height' => $request->height,
        'width' => $request->width,
        'length' => $request->length,
        'diameter' => $request->diameter,
        'weight' => $request->weight,
        'active' => $request->active,
      ]);

      Log::info('Embalagem cadastrada.', ['packaging_id' => $packaging->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('packagings.show', ['packaging' => $packaging->id])->with('success', 'Embalagem cadastrada com sucesso!');
    } catch (Exception $e) {

      Log::notice('Embalagem não cadastrada.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Embalagem não cadastrada!');
    }
  }

  public function edit(Packaging $packaging)
  {
    return view('packagings.edit', ['packaging' => $packaging]);
  }

  public function update(PackagingRequest $request, Packaging $packaging)
  {
    try {
      $packaging->update([
        'name' => $request->name,
        'height' => $request->height,
        'width' => $request->width,
        'length' => $request->length,
        'diameter' => $request->diameter,
        'weight' => $request->weight,
        'active' => $request->active,
      ]);

      Log::info('Embalagem editada.', ['packaging_id' => $packaging->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('packagings.show', ['packaging' => $packaging->id])->with('success', 'Embalagem editada com sucesso!');
    } catch (Exception $e) {

      Log::notice('Embalagem não editada.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Embalagem não editada!');
    }
  }

  public function destroy(Packaging $packaging)
  {
    try {

      $packaging->delete();

      Log::info('Embalagem apagada.', ['packaging_id' => $packaging->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('packagings.index')->with('success', 'Embalagem apagada com sucesso!');
    } catch (Exception $e) {

      Log::notice('Embalagem não apagada.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Embalagem não apagada!');
    }
  }
}
