from pathlib import Path
path = Path('app/Http/Controllers/CajaController.php')
text = path.read_text(encoding='cp1252')
start = text.index('    public function ingresoegreso($id)')
end = text.index('    public function store_ingresos_egresos')
new_block = """    public function ingresoegreso($id)
    {
        $caja = Caja::with(
            'movimientos.metodosPago.metodoPago',
            'ventas.pagos'
        )->findOrFail($id);

        $movimientos = collect();

        $totalesMetodos = [
            'efectivo' => 0,
            'debito' => 0,
            'credito' => 0,
            'transferencia' => 0,
        ];

        $movimientos->push([
            'tipo' => 'apertura',
            'descripcion' => 'Apertura de caja',
            'monto' => $caja->monto_inicial,
            'fecha' => $caja->fecha_apertura,
            'metodo' => 'Apertura',
            'metodo_codigo' => 'apertura',
        ]);

        foreach ($caja->movimientos as $movimiento) {
            if ($movimiento->metodosPago && $movimiento->metodosPago->count()) {
                foreach ($movimiento->metodosPago as $mp) {
                    $metodoCodigo = Str::of($mp->metodoPago->codigo ?? '')
                        ->trim()
                        ->lower()
                        ->toString();

                    $movimientos->push([
                        'tipo' => $movimiento->tipo,
                        'descripcion' => $movimiento->descripcion,
                        'monto' => $mp->monto,
                        'fecha' => $movimiento->created_at,
                        'metodo' => $mp->metodoPago->nombre ?? ucfirst($metodoCodigo),
                        'metodo_codigo' => $metodoCodigo ?: 'desconocido',
                    ]);

                    if ($metodoCodigo && isset($totalesMetodos[$metodoCodigo])) {
                        $totalesMetodos[$metodoCodigo] += $movimiento->tipo === 'egreso'
                            ? -$mp->monto
                            : $mp->monto;
                    }
                }
            } else {
                $movimientos->push([
                    'tipo' => $movimiento->tipo,
                    'descripcion' => $movimiento->descripcion,
                    'monto' => $movimiento->monto,
                    'fecha' => $movimiento->created_at,
                    'metodo' => 'Efectivo',
                    'metodo_codigo' => 'efectivo',
                ]);

                if ($movimiento->tipo === 'ingreso') {
                    $totalesMetodos['efectivo'] += $movimiento->monto;
                } elseif ($movimiento->tipo === 'egreso') {
                    $totalesMetodos['efectivo'] -= $movimiento->monto;
                }
            }
        }

        foreach ($caja->ventas as $venta) {
            foreach ($venta->pagos as $pago) {
                $metodoCodigo = Str::of($pago->metodo ?? '')
                    ->ascii()
                    ->trim()
                    ->lower()
                    ->toString();

                if ($metodoCodigo === 'efectivo') {
                    continue;
                }

                $movimientos->push([
                    'tipo' => 'pago',
                    'descripcion' => 'Venta #' . $venta->id,
                    'monto' => $pago->monto,
                    'fecha' => $pago->created_at,
                    'metodo' => Str::title(Str::of($pago->metodo ?? $metodoCodigo)->ascii()->toString()),
                    'metodo_codigo' => $metodoCodigo ?: 'desconocido',
                ]);

                if ($metodoCodigo && isset($totalesMetodos[$metodoCodigo])) {
                    $totalesMetodos[$metodoCodigo] += $pago->monto;
                }
            }
        }

        $movimientos = $movimientos->sortBy('fecha')->values();

        $saldo = 0;
        $movimientos = $movimientos->map(function ($mov) use (&$saldo) {
            if ($mov['tipo'] === 'apertura') {
                $saldo += $mov['monto'];
            }

            $metodoCodigo = strtolower($mov['metodo_codigo'] ?? '');
            if ($metodoCodigo === 'efectivo') {
                if (in_array($mov['tipo'], ['ingreso', 'apertura'])) {
                    $saldo += $mov['monto'];
                }

                if ($mov['tipo'] === 'egreso') {
                    $saldo -= $mov['monto'];
                }
            }

            $mov['saldo'] = $saldo;
            return $mov;
        });

        $saldoFinal = $movimientos->last()['saldo'] ?? 0;

        $metodosPago = MetodoPago::where('activo', true)->get();

        return view('admin.cajas.ingresoegreso', compact('caja', 'movimientos', 'saldoFinal', 'totalesMetodos', 'metodosPago'));
    }

"""
path.write_text(text[:start] + new_block + text[end:], encoding='cp1252')
