var url = window.location + '/rest';

var ProductList = React.createClass({

    fetchFromServer: function () {
        $.ajax({
            url: this.props.url,
            dataType: 'json',
            cache: false,
            success: function (data) {
                this.setState({products: data, loaded: true});
            }.bind(this),
            error: function (xhr, status, err) {
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    },

    _renderRow: function (iterator, product) {
        return(
            < tr key = {product.id} >
                < td > {iterator} < / td >
                < td > < a href = "{{ path('product_view', {id: product.id}) }}" class = "link-unstyled" > { product.name } < / a > < / td >
                < td > { product.price } < / td >
                < td > { product.stock } < / td >
                < td > < / td >
            <  / tr >
        );
    },

    getInitialState: function () {
        return {products: [], loaded: false}
    },

    componentDidMount: function () {
        this.fetchFromServer();
        //setInterval(this.fetchFromServer, 10000);
    },

    render: function () {
        var iterator = 0;
        var self = this;
        if (this.state.products.length > 0) {
            return (
                < div className = "table-responsive" >
                    < table className = "table table-striped table-hover" >
                        < thead >
                        < tr >
                            < th > # < / th >
                            < th > Nom < / th >
                            < th > Prix < / th >
                            < th > Stock < / th >
                            < th > Actions < / th >
                        <  / tr >
                        <  / thead >
                        < tbody >
                        { this.state.products.map(function (element) {
                            return self._renderRow(++iterator, element);
                        }) }
                        <  / tbody >
                    <  / table >
                <  / div >
            );
        } else if (this.state.loaded == false) {
            return (
                < p className = "text-center" > < i className = "fa fa-spinner fa-spin" > < / i > Loading < / p >
            );
        } else {
            return (
                < p className = "text-center" > No matching results < / p >
            );
        }

    }
});


var Table = React.createClass({
    render: function () {
        return(
            < div className = "box box-success" >
                < div className = "box-header with-border" >
                    < div className = "box-tools" >
                        {/*<a href="{{ path('product_add') }}" class="btn btn-success btn-box-tool"><i class="fa fa-plus"></i> Ajouter</a>*/}
                    <  / div >
                    < h2 className = "box-title" > {this.props.title} < / h2 >
                <  / div >
                < ProductList url = {this.props.url} /  >
            <  / div >
        );
    }
});

var ProductSearch = React.createClass({

    render: function () {
        return (
            < input type = "text" /  >
        );
    }
});

ReactDOM.render(
    < Table url = {url} title = "Liste des Produits" /  > ,
    document.getElementById('table')
);