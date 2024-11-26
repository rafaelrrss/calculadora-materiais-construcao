<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Materiais</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f7fc;
            font-family: Arial, sans-serif;
        }
        main {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 50px auto;
        }
        h1 {
            color: #007bff;
            font-size: 2.5rem;
            margin-bottom: 30px;
        }
        .fieldset-legend {
            font-weight: bold;
            color: #333;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .resultado {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-top: 30px;
        }
        .resultado p {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <main>
        <h1 class="text-center">Calculadora de Materiais</h1>

        <div class="container">
            <div class="row g-2">
                <!-- Comodo Section -->
                <fieldset class="row g-2">
                    <legend class="fieldset-legend">Comôdo</legend>
                    <div class="col-md-6">
                        <label for="comodo-largura" class="form-label">Largura(m)</label>
                        <input type="number" class="form-control" id="comodo-largura" required>
                    </div>
                    <div class="col-md-6">
                        <label for="comodo-comprimento" class="form-label">Comprimento(m)</label>
                        <input type="number" class="form-control" id="comodo-comprimento" required>
                    </div>
                </fieldset>
                
                <!-- Piso Section -->
                <fieldset class="row g-2">
                    <legend class="fieldset-legend">Piso</legend>
                    <div class="col-md-6">
                        <label for="piso-largura" class="form-label">Largura(m)</label>
                        <input type="number" class="form-control" id="piso-largura" required>
                    </div>
                    <div class="col-md-6">
                        <label for="piso-comprimento" class="form-label">Comprimento(m)</label>
                        <input type="number" class="form-control" id="piso-comprimento" required>
                    </div>
                </fieldset>

                <!-- Margem Section -->
                <div class="col-md-12"> 
                    <label for="margem" class="form-label">Margem(%)</label>
                    <input type="number" class="form-control" id="margem" required>
                </div>

                <!-- Calculate Button -->
                <div class="col-md-12">
                    <button class="btn btn-primary" id="btn-calcular" onclick="processar();">Calcular</button>
                </div>

                <!-- Result Section -->
                <div class="col-md-12">
                    <div id="resultado" class="resultado"></div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- JavaScript for processing calculations -->
    <script>
        function processar() {
            const comodoLargura = document.getElementById("comodo-largura").value;
            const comodoComprimento = document.getElementById("comodo-comprimento").value;
            const pisoLargura = document.getElementById("piso-largura").value;
            const pisoComprimento = document.getElementById("piso-comprimento").value;
            const margem = document.getElementById("margem").value;

            if (comodoLargura <= 0) {
                alert("A largura do comôdo deve ser maior que 0");
                return;
            }

            if (comodoComprimento <= 0) {
                alert("O comprimento do comôdo deve ser maior que 0");
                return;
            }

            if (pisoLargura <= 0) {
                alert("A largura do piso deve ser maior que 0");
                return;
            }

            if (pisoComprimento <= 0) {
                alert("O comprimento do piso deve ser maior que 0");
                return;
            }

            if (margem <= 0) {
                alert("A margem deve ser maior que 0");
                return;
            }

            const medidas = {
                comodoLargura,
                comodoComprimento,
                pisoLargura,
                pisoComprimento,
                margem
            };

            const dados = JSON.stringify(medidas);

            fetch('/calculo.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: dados
            })
            .then(resposta => resposta.json())
            .then(resultado => {
                let elementoResultado = document.getElementById("resultado");
                const exibir = `
                    <p>Área do cômodo: ${resultado.areaComodo} m²</p>
                    <p>Área do piso: ${resultado.areaPiso} m²</p>
                    <p>Quantidade de piso: ${resultado.quantidade}</p>
                    <p>Quantidade para margem: ${resultado.quantidadeMargem}</p>
                    <p>Total a ser comprado: ${resultado.quantidadeTotal}</p>
                `;
                elementoResultado.innerHTML = exibir;
            })
            .catch(erro => {
                alert("Ocorreu um erro");
            });
        }
    </script>
</body>
</html>
