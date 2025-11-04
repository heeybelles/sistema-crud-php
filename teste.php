<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <title>Art's Nany</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top bg-white">
  <div class="container-fluid d-flex align-items-center justify-content-between">

    <a class="navbar-brand" href="#">Glamour</a>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link mx-lg-2 " href="#home">Início</a></li>
        <li class="nav-item"><a class="nav-link mx-lg-2" href="#about">Quem somos?</a></li>
        <li class="nav-item"><a class="nav-link mx-lg-2" href="#services">Produtos</a></li>
         <li class="nav-item"><a class="nav-link mx-lg-2" href="#avaliate">Avaliações</a></li>
        <li class="nav-item"><a class="nav-link mx-lg-2" href="#contact">Contato</a></li>
      </ul>
    </div>

    <div class="d-flex align-items-center">
      <a href="#" class="login-button me-2">Entrar</a>
      <button class="navbar-toggler pe-0" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
</nav>

  <section class="hero-section" id="home">
   <img src="img/tamplete-hero.jpg" alt="Hero Image" class="hero-image">

    <h1 class="hero-title"> Sua hora de brilhar chegou!</h1>
    <p class="hero-subtitle">Conheça os nossos cósmesticos e se encante! </p>
    <a href="#" class="hero-button">Inscreva-se</a>
</section>

   <section class="about-section" id="about">
         <h2>Quem somos?</h2><br>
         <div class="card mb-3" style="max-width: 70%; height:300px;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="img/img-about.jpg" class="img-fluid rounded-start" alt="logo-img" style="width: 100%; height: 100%; margin-top:26px;margin-left:10px; border-radius: 50%;">
    </div>
    <div class="col-md-8">
  <div class="card-body">
   <br>
    <p class="card-text" style="text-align: justify; margin-left: 20px; margin-top:40px;">
      A Glamour nasceu da paixão por fragrâncias que despertam emoções e refletem a essência de cada pessoa. Com dedicação e sensibilidade, criamos perfumes que transmitem confiança, elegância e bem-estar, transformando o ato de se perfumar em uma expressão única de quem você é.
    </p>
    <p class="card-text"><small class="text-body-secondary" style="margin-top: 10px">Última atualização: 3 minutos atrás</small></p>
    </div>
   </div>
  </div>
 </div>
</section>

<section class="services-section" id="services">
        <h2>Produtos</h2>
        <p style="text-align: center;">
          Confira os produtos que oferecemos. 
        </p>
       <div class="card" style="width: 18rem;">
      <img src="..." class="card-img-top" alt="...">
    <div class="card-body">
    <h5 class="card-title">Nome </h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
    <a href="#" class="btn btn-primary">Comprar</a>
  </div>
</div>
</section>

<section class="avaliate-section" id="avaliate">
        <h2>Avaliações</h2>
        <p style="text-align: center;">
          Veja o que nossos clientes estão dizendo sobre nós.
        </p>
        <div class="card mb-3" style="max-width: 540px;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="..." class="img-fluid rounded-start" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">Nome do Cliente</h5>
        <p class="card-text"></p>
        <span class="star"></span>
        </div>
    </div>
    </div>
</div>
</section>
<section class="contact-section" id="contact">
  <h2>Contato</h2>

  <div class="contact-container">
    <!-- Informações da empresa -->
    <div class="info">
      <p>📍 Endereço: Rua Exemplo, 123 - Cidade, Estado</p>
      <p>📞 Telefone: (11) 1234-5678</p>
      <p>✉️ Email: contato@glamour.com</p>
    </div>

    <!-- Formulário de contato -->
    <form>
      <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input type="text" class="form-control" id="name" placeholder="Seu nome">
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Seu email">
      </div>

      <div class="mb-3">
        <label for="message" class="form-label">Mensagem</label>
        <textarea class="form-control" id="message" rows="4" placeholder="Sua mensagem"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
  </div>
</section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
