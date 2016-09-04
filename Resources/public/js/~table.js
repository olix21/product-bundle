import { createStore } from 'redux'


var initialState = {
    filter: '',
    products: []
};


const FILTER = 'FILTER';

function setFilter(name) {
    return {
        type: FILTER,
        value: name
    }
}

function product(state, action)
{
    switch(action.type)
    {
        case FILTER:
            if(product.name == action.value)
                return {...state, display: true};
            else return {...state, display: false};
    }
}


function products(state = initialState, action){
    switch(action.type)
    {
        case FILTER:
            return {...state, filter: action.filter, products: state.products.map(function(product){
                return product(product, action);
            })};
        default: return state;
    }
}*/


var ProductList = React.createClass({

    getInitialState: function() {
        return {products: null, loading: true};
    },

    fetchFromServer: function()
    {
        $.ajax({
            url: window.location + '/rest',
            dataType: 'json',
            cache: false,
            success: function(data) {
                data.map(function(element){
                });
                this.setState({products: data, loading: false});
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    },

    componentDidMount: function() {
        this.fetchFromServer();
        setInterval(this.fetchFromServer, 5000);
    },

    _renderProduct: function(product){
        return (
            <tr>
                <td><small>{/*{ loop.index }*/}</small></td>
                <td><a href="{{ path('product_view', {id: product.id}) }}" class="link-unstyled">{ product.name }</a></td>
                {/*{#<td><small>{{ product.brand.name }}</small></td>#}
                {#<td><small>{% for category in product.categories%}{{ category.name }}, {% endfor %}</small></td>#}*/}
                <td>{/*{#{% if product.isPromotion == 1 %}
                    <strike>{{ product.price }}€</strike> > {{ product.promotionPrice|number_format(2) }}€
                {% else %}#}*/}
                    { product.price }€
                    {/*{#{% endif %}#}*/}
                </td>
                <td>{/*{ product.stock }*/}</td>
                <td>{/*{% include 'DyweeProductBundle:BaseProduct:state.html.twig' %}*/}
                </td>
                <td>
                    <div class="btn-group btn-group-xs">
                        <a href="{{ path('product_view', {id: product.id}) }}" class="btn btn-xs btn-default"><i class="fa fa-eye"></i> </a>
                        <a href="{{ path('product_update', {id: product.id}) }}" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i> </a>
                    </div>

                    <a href="{{ path('product_delete', {id: product.id}) }}" class="btn btn-xs btn-danger" data-confirm="Êtes-vous sûr de vouloir supprimer ce produit:" data-name="{{ product.name }}"><i class="fa fa-trash-o"></i> </a>
                </td>
            </tr>
        );
    },

    render: function () {
        var self = this;
        if (this.state.products) {
            return (
                <div className="table-responsive">
                    <table className="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            {/*{#<th>Marque</th>#}
                            {#<th>Catégories</th>#}*/}
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        { this.state.products.map(function(element){
                            return self._renderProduct(element);
                        }) }
                        </tbody>
                    </table>
                </div>
            );
        }
        else if(this.state.loading) {
            return (
                <div className="box-body">
                    <p className="text-center"><i className="fa fa-spinner fa-spin"></i></p>
                </div>
            );
        }
        else{
            return (
                <div className="box-body">
                    <p>Il n'y a pas de produit répondant à ces critères</p>
                </div>
            );
        }

    }
});

var FilterForm = React.createClass({

    getInitialState: function(){
        return  {search: ''}
    },

    handleTextChange: function(e) {
        this.setState({search: e.target.value});
    },

    render: function()
    {
        return(
            <form className="commentForm">
                <input
                    type="text"
                    placeholder="Search product"
                    value={this.state.search}
                    onChange={this.handleTextChange}
                />
            </form>
        );
    }

});


ReactDOM.render(
    <ProductList />,
    document.getElementById('productTable')
);

ReactDOM.render(
    <FilterForm />,
    document.getElementById('productFilter')
);


/*

 {% for product in products %}

 {% endfor %}

 */