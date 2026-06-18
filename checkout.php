<?php include 'header.php'; ?>

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Pagar Pedido</h1>
                </div>
            </div>
            <div class="col-lg-7"></div>
        </div>
    </div>
</div>

<div class="untree_co-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="border p-4 rounded" role="alert">
                    ¿Cliente recurrente? <a href="#">Haz clic aquí</a> para iniciar sesión
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5 mb-md-0">
                <h2 class="h3 mb-3 text-black">Datos de Facturación</h2>
                <div class="p-3 p-lg-5 border bg-white">
                    <div class="form-group">
                        <label for="c_country" class="text-black">País <span class="text-danger">*</span></label>
                        <select id="c_country" class="form-control">
                            <option value="1">Selecciona un país</option>
                            <option value="PE" selected>Perú</option>
                            <option value="CO">Colombia</option>
                            <option value="AR">Argentina</option>
                            <option value="CL">Chile</option>
                            <option value="MX">México</option>
                            <option value="ES">España</option>
                            <option value="US">Estados Unidos</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="c_fname" class="text-black">Nombres <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="c_fname" name="c_fname">
                        </div>
                        <div class="col-md-6">
                            <label for="c_lname" class="text-black">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="c_lname" name="c_lname">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="c_companyname" class="text-black">Nombre de la Empresa</label>
                            <input type="text" class="form-control" id="c_companyname" name="c_companyname">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="c_address" class="text-black">Dirección <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="c_address" name="c_address" placeholder="Dirección">
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <input type="text" class="form-control" placeholder="Departamento, oficina, etc. (opcional)">
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="c_state_country" class="text-black">Departamento / Provincia <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="c_state_country" name="c_state_country">
                        </div>
                        <div class="col-md-6">
                            <label for="c_postal_zip" class="text-black">Código Postal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="c_postal_zip" name="c_postal_zip">
                        </div>
                    </div>

                    <div class="form-group row mb-5">
                        <div class="col-md-6">
                            <label for="c_email_address" class="text-black">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="c_email_address" name="c_email_address">
                        </div>
                        <div class="col-md-6">
                            <label for="c_phone" class="text-black">Teléfono <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="c_phone" name="c_phone" placeholder="Número de teléfono">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="c_create_account" class="text-black" data-bs-toggle="collapse" href="#create_an_account" role="button" aria-expanded="false" aria-controls="create_an_account"><input type="checkbox" value="1" id="c_create_account"> ¿Crear una cuenta?</label>
                        <div class="collapse" id="create_an_account">
                            <div class="py-2 mb-4">
                                <p class="mb-3">Crea una cuenta ingresando la información a continuación. Si ya tienes una cuenta, inicia sesión arriba.</p>
                                <div class="form-group">
                                    <label for="c_account_password" class="text-black">Contraseña</label>
                                    <input type="email" class="form-control" id="c_account_password" name="c_account_password" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="c_ship_different_address" class="text-black" data-bs-toggle="collapse" href="#ship_different_address" role="button" aria-expanded="false" aria-controls="ship_different_address"><input type="checkbox" value="1" id="c_ship_different_address"> ¿Enviar a una dirección diferente?</label>
                        <div class="collapse" id="ship_different_address">
                            <div class="py-2">

                                <div class="form-group">
                                    <label for="c_diff_country" class="text-black">País <span class="text-danger">*</span></label>
                                    <select id="c_diff_country" class="form-control">
                                        <option value="1">Selecciona un país</option>
                                        <option value="PE" selected>Perú</option>
                                        <option value="CO">Colombia</option>
                                        <option value="AR">Argentina</option>
                                        <option value="CL">Chile</option>
                                        <option value="MX">México</option>
                                        <option value="ES">España</option>
                                        <option value="US">Estados Unidos</option>
                                    </select>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="c_diff_fname" class="text-black">Nombres <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_diff_fname" name="c_diff_fname">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="c_diff_lname" class="text-black">Apellidos <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_diff_lname" name="c_diff_lname">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="c_diff_companyname" class="text-black">Nombre de la Empresa</label>
                                        <input type="text" class="form-control" id="c_diff_companyname" name="c_diff_companyname">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <div class="col-md-12">
                                        <label for="c_diff_address" class="text-black">Dirección <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_diff_address" name="c_diff_address" placeholder="Dirección">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Departamento, oficina, etc. (opcional)">
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="c_diff_state_country" class="text-black">Departamento / Provincia <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_diff_state_country" name="c_diff_state_country">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="c_diff_postal_zip" class="text-black">Código Postal <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_diff_postal_zip" name="c_diff_postal_zip">
                                    </div>
                                </div>

                                <div class="form-group row mb-5">
                                    <div class="col-md-6">
                                        <label for="c_diff_email_address" class="text-black">Correo Electrónico <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_diff_email_address" name="c_diff_email_address">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="c_diff_phone" class="text-black">Teléfono <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_diff_phone" name="c_diff_phone" placeholder="Número de teléfono">
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="c_order_notes" class="text-black">Notas del Pedido</label>
                        <textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5" class="form-control" placeholder="Escribe tus notas aquí..."></textarea>
                    </div>

                </div>
            </div>
            <div class="col-md-6">

                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black">Código de Cupón</h2>
                        <div class="p-3 p-lg-5 border bg-white">

                            <label for="c_code" class="text-black mb-3">Ingresa tu código de cupón si tienes uno</label>
                            <div class="input-group w-75 couponcode-wrap">
                                <input type="text" class="form-control me-2" id="c_code" placeholder="Código de Cupón" aria-label="Código de Cupón" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-black btn-sm" type="button" id="button-addon2">Aplicar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black">Tu Pedido</h2>
                        <div class="p-3 p-lg-5 border bg-white">
                            <table class="table site-block-order-table mb-5">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="order-product-name">Producto <strong class="mx-2">x</strong> 1</td>
                                        <td id="order-product-price">S/ 0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-black font-weight-bold"><strong>Subtotal</strong></td>
                                        <td class="text-black" id="order-subtotal">S/ 0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-black font-weight-bold"><strong>Total del Pedido</strong></td>
                                        <td class="text-black font-weight-bold"><strong id="order-total">S/ 0.00</strong></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="border p-3 mb-3">
                                <h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">Transferencia Bancaria Directa</a></h3>
                                <div class="collapse" id="collapsebank">
                                    <div class="py-2">
                                        <p class="mb-0">Realiza tu pago directamente a nuestra cuenta bancaria. Usa tu número de pedido como referencia. El pedido se procesará una vez confirmado el pago.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border p-3 mb-3">
                                <h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse" href="#collapsecheque" role="button" aria-expanded="false" aria-controls="collapsecheque">Pago con Cheque</a></h3>
                                <div class="collapse" id="collapsecheque">
                                    <div class="py-2">
                                        <p class="mb-0">Realiza tu pago con cheque a nombre de Don Lucho. El pedido se procesará una vez que el cheque sea cobrado.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border p-3 mb-5">
                                <h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse" href="#collapsepaypal" role="button" aria-expanded="false" aria-controls="collapsepaypal">Pago contra Entrega</a></h3>
                                <div class="collapse" id="collapsepaypal">
                                    <div class="py-2">
                                        <p class="mb-0">Paga en efectivo o con tarjeta cuando recibas tu pedido en la puerta de tu casa.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-black btn-lg py-3 btn-block" onclick="window.location='thankyou.php'">Realizar Pedido</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
