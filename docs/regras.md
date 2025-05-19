# 🧾Etapas do processo de remessa:

envios_dados -> Cliente solicitou

em_producao -> Produção iniciou

expedicao -> Produção finalizou

pedido_liberado -> Expedição liberou

finalizado -> Recepção deu baixa

# ✅Ordem recomendada para organização:

Repository
Lida com o banco de dados (buscas, atualizações, filtros).

Service
Contém a lógica de negócio. Recebe os dados do controller e usa o repository para interagir com o banco.

Controller
Responsável por receber a requisição, validar os dados e chamar os métodos do service.
