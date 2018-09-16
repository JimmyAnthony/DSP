<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('return-tab')){
		var ireturn = {
			id:'ireturn',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/return/',
			opcion:'I',
			id_lote:0,
			shi_codigo:0,
			fac_cliente:0,
			init:function(){
				Ext.tip.QuickTipManager.init();

				Ext.define('Task', {
				    extend: 'Ext.data.TreeModel',
				    fields: [
				        {name: 'id_lote', type: 'string'},
				        {name: 'shi_codigo', type: 'string'},
				        {name: 'fac_cliente', type: 'string'},
				        {name: 'id_det', type: 'string'},
				        {name: 'lot_estado', type: 'string'},
	                    {name: 'tipdoc', type: 'string'},
	                    {name: 'nombre', type: 'string'},
	                    {name: 'lote_nombre', type: 'string'},
	                    {name: 'descripcion', type: 'string'},
	                    {name: 'fecha', type: 'string'},
	                    {name: 'tot_folder', type: 'string'},
	                    {name: 'tot_pag', type: 'string'},
	                    {name: 'tot_errpag', type: 'string'},
	                    {name: 'id_user', type: 'string'},
	                    {name: 'usr_update', type: 'string'},
	                    {name: 'fec_update', type: 'string'},
	                    {name: 'estado', type: 'string'}
				    ]
				});
				var storeTree = new Ext.data.TreeStore({
	                model: 'Task',
				    autoLoad:false,
	                proxy: {
	                    type: 'ajax',
	                    url: ireturn.url+'get_list_return/'
	                },
	                folderSort: true,
	                listeners:{
	                	beforeload: function (store, operation, opts) {
					    },
	                    load: function(obj, records, successful, opts){
	                 		Ext.getCmp(ireturn.id + '-grid').doLayout();
	                 		storeTree.removeAt(0);
	                 		Ext.getCmp(ireturn.id + '-grid').collapseAll();
		                    Ext.getCmp(ireturn.id + '-grid').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                     });
	                    }
	                }
	            });
				var store = Ext.create('Ext.data.Store',{
                fields: [
                    {name: 'id_lote', type: 'string'},
                    {name: 'tipdoc', type: 'string'},
                    {name: 'nombre', type: 'string'},
                    {name: 'fecha', type: 'string'},
                    {name: 'tot_folder', type: 'string'},                    
                    {name: 'id_user', type: 'string'},                    
                    {name: 'estado', type: 'string'}
                ],
                autoLoad:false,
                proxy:{
                    type: 'ajax',
                    url: ireturn.url+'get_list_return/',
                    reader:{
                        type: 'json',
                        rootProperty: 'data'
                    }
                },
                listeners:{
                    load: function(obj, records, successful, opts){
                        
                    }
                }
            });
			var store_shipper = Ext.create('Ext.data.Store',{
                fields: [
                    {name: 'shi_codigo', type: 'string'},
                    {name: 'shi_nombre', type: 'string'},
                    {name: 'shi_logo', type: 'string'},
                    {name: 'fec_ingreso', type: 'string'},                    
                    {name: 'shi_estado', type: 'string'},
                    {name: 'id_user', type: 'string'},
                    {name: 'fecha_actual', type: 'string'}
                ],
                autoLoad:true,
                proxy:{
                    type: 'ajax',
                    url: ireturn.url+'get_list_shipper/',
                    reader:{
                        type: 'json',
                        rootProperty: 'data'
                    }
                },
                listeners:{
                    load: function(obj, records, successful, opts){
                        
                    }
                }
            });
            var store_contratos = Ext.create('Ext.data.Store',{
                fields: [
                    {name: 'fac_cliente', type: 'string'},
                    {name: 'cod_contrato', type: 'string'},
                    {name: 'pro_descri', type: 'string'}
                ],
                autoLoad:false,
                proxy:{
                    type: 'ajax',
                    url: ireturn.url+'get_list_contratos/',
                    reader:{
                        type: 'json',
                        rootProperty: 'data'
                    }
                },
                listeners:{
                    load: function(obj, records, successful, opts){
                        
                    }
                }
            });

		    var myDataLote = [
				['A','Activo'],
			    ['I','Inactivo']
			];
			var store_estado_lote = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'estado',
		        autoLoad: true,
		        data: myDataLote,
		        fields: ['code', 'name']
		    });

		    

				var panel = Ext.create('Ext.form.Panel',{
					id:ireturn.id+'-form',
					bodyStyle: 'background: transparent',
					border:false,
					layout:'border',
					defaults:{
						border:false
					},
					tbar:[],
					items:[
						
						
					]
				});
				tab.add({
					id:ireturn.id+'-tab',
					border:false,
					autoScroll:true,
					closable:true,
					layout:'border',
					items:[
						{
                            region:'north',
                            layout:'border',
                            border:false,
                            height:90,
                            items:[
								{
		                            region:'west',
		                            border:false,
		                            xtype: 'uePanelS',
		                            logo: 'CL',
		                            title: 'Clientes y Contratos',
		                            legend: 'Seleccione Clientes Registrados',
		                            width:600,
		                            //height:90,
		                            items:[
		                                {
		                                    xtype:'panel',
		                                    border:false,
		                                    bodyStyle: 'background: transparent',
		                                    padding:'2px 5px 1px 5px',
		                                    layout:'column',
		                                    items: [
		                                    	{
			                                   		width: 250,border:false,
			                                    	padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
			                                 		items:[
			                                                {
			                                                    xtype:'combo',
			                                                    fieldLabel: 'Cliente',
			                                                    id:ireturn.id+'-cbx-cliente',
			                                                    store: store_shipper,
			                                                    queryMode: 'local',
			                                                    triggerAction: 'all',
			                                                    valueField: 'shi_codigo',
			                                                    displayField: 'shi_nombre',
			                                                    emptyText: '[Seleccione]',
			                                                    labelAlign:'right',
			                                                    //allowBlank: false,
			                                                    labelWidth: 50,
			                                                    width:'100%',
			                                                    anchor:'100%',
			                                                    //readOnly: true,
			                                                    listeners:{
			                                                        afterrender:function(obj, e){
			                                                        },
			                                                        select:function(obj, records, eOpts){
			                                                        	Ext.getCmp(ireturn.id+'-cbx-contrato').setValue('');
			                                                			ireturn.getContratos(records.get('shi_codigo'));
			                                                        }
			                                                    }
			                                                }
			                                 		]
			                                    },
			                                    {
			                                   		width: 270,border:false,
			                                    	padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
			                                 		items:[
			                                                {
			                                                    xtype:'combo',
			                                                    fieldLabel: 'Contrato',
			                                                    id:ireturn.id+'-cbx-contrato',
			                                                    store: store_contratos,
			                                                    queryMode: 'local',
			                                                    triggerAction: 'all',
			                                                    valueField: 'fac_cliente',
			                                                    displayField: 'pro_descri',
			                                                    emptyText: '[Seleccione]',
			                                                    labelAlign:'right',
			                                                    //allowBlank: false,
			                                                    labelWidth: 50,
			                                                    width:'100%',
			                                                    anchor:'100%',
			                                                    listeners:{
			                                                        afterrender:function(obj, e){

			                                                        },
			                                                        select:function(obj, records, eOpts){
			                                                			
			                                                        }
			                                                    }
			                                                }
			                                 		]
			                                    }
		                                    ]
		                                }
		                            ]
		                        },
		                        {
		                            region:'center',
		                            border:false,
		                            xtype: 'uePanelS',
		                            logo: 'LT',
		                            title: 'Listado de Lotes',
		                            legend: 'Búsqueda de Lotes registrados',
		                            width:1000,
		                            height:90,
		                            items:[
		                                {
		                                    xtype:'panel',
		                                    border:false,
		                                    bodyStyle: 'background: transparent',
		                                    padding:'2px 5px 1px 5px',
		                                    layout:'column',

		                                    items: [
		                                    	{
		                                            width:100,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'N° Lote',
		                                                    id:ireturn.id+'-txt-lote',
		                                                    labelWidth:50,
		                                                    maskRe: /[0-9]/,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                }
		                                            ]
		                                        },
		                                        {
		                                            width:250,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'Nombre Lote',
		                                                    id:ireturn.id+'-txt-lotizer',
		                                                    labelWidth:80,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                }
		                                            ]
		                                        },
		                                        {
			                                        width: 160,border:false,
			                                        padding:'0px 2px 0px 0px',  
			                                    	bodyStyle: 'background: transparent',
			                                        items:[
			                                            {
			                                                xtype:'datefield',
			                                                id:ireturn.id+'-txt-fecha-filtro',
			                                                fieldLabel:'Fecha',
			                                                labelWidth:60,
			                                                labelAlign:'right',
			                                                value:new Date(),
			                                                format: 'Ymd',
			                                                //readOnly:true,
			                                                width: '100%',
			                                                anchor:'100%'
			                                            }
			                                        ]
			                                    },
		                                        {
			                                   		width: 150,border:false,
			                                    	padding:'0px 2px 0px 0px',  
			                                    	bodyStyle: 'background: transparent',
			                                 		items:[
			                                                {
			                                                    xtype:'combo',
			                                                    fieldLabel: 'Estado',
			                                                    id:ireturn.id+'-txt-estado-filter',
			                                                    store: store_estado_lote,
			                                                    queryMode: 'local',
			                                                    triggerAction: 'all',
			                                                    valueField: 'code',
			                                                    displayField: 'name',
			                                                    emptyText: '[Seleccione]',
			                                                    labelAlign:'right',
			                                                    //allowBlank: false,
			                                                    labelWidth: 50,
			                                                    width:'100%',
			                                                    anchor:'100%',
			                                                    //readOnly: true,
			                                                    listeners:{
			                                                        afterrender:function(obj, e){

			                                                            Ext.getCmp(ireturn.id+'-txt-estado-filter').setValue('A');
			                                                        },
			                                                        select:function(obj, records, eOpts){
			                                                
			                                                        }
			                                                    }
			                                                }
			                                 		]
			                                    },
		                                        {
		                                            width: 80,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
									                        xtype:'button',
									                        text: 'Buscar',
									                        icon: '/images/icon/binocular.png',
									                        listeners:{
									                            beforerender: function(obj, opts){
									                            },
									                            click: function(obj, e){	             	
									                            	var name = Ext.getCmp(ireturn.id+'-txt-lotizer').getValue();
		                               					            ireturn	.getReloadGridlotizer(name);


									                            }
									                        }
									                    }
		                                            ]
		                                        },
		                                        {
		                                            width: 80,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
									                        xtype:'button',
									                        text: 'Devolver',
									                        icon: '/images/icon/if_General_Office_36_2530817.png',
									                        listeners:{
									                            beforerender: function(obj, opts){
									                            },
									                            click: function(obj, e){	
											                    	var records = Ext.getCmp(ireturn.id + '-grid');
																    var objectStore = records.getStore(),
																        dataCollection = [];

																    if (objectStore.data.items !== undefined) {
																    	
																        $.each(objectStore.data.items, function (index, objectData) {
																        	
																            if (!objectData.data.leaf) {

																            } else {
																            	if(objectData.data.done == true) {
																            	var nombre = objectData.data.lote_nombre;
																            	var id_lote = objectData.data.id_lote;
																            	var id_det = objectData.data.id_det;
																            	var arr1 = [nombre,id_lote,id_det] ;
																            	dataCollection.push(arr1);
																                }
																            }
																        })

																    };
																    ireturn.getFormMant(dataCollection);
									                            }
									                        }
									                    }
		                                            ]
		                                        }
		                                    ]
		                                }
		                            ]
		                        }

		                    ]
		                },
						{
							region:'center',
							layout:'border',
							items:[
								{
									region:'center',

									layout:'border',
									items:[
										{
											region:'center',
											border:false,
											layout:'fit',
											items:[
												{
							                        xtype: 'treepanel',
											        useArrows: true,
											        rootVisible: true,
											        multiSelect: true,
							                        id: ireturn.id + '-grid',
							                        columnLines: true,
							                        store: storeTree,
										            columns: [
											            {
											            	xtype: 'treecolumn',
											            	id: ireturn.id + '-grid-lote_nombre',
						                                    text: 'Nombre',
						                                    dataIndex: 'lote_nombre',
						                                    sortable: true,
						                                    flex: 1
						                                },
						                                {
						                                 	hidden:true,
						                                    text: 'id_lote',
						                                    dataIndex: 'id_lote',
						                                    flex: 1
						                                },
						                                {
						                                	hidden:true,
						                                    text: 'id_det',
						                                    dataIndex: 'id_det',
						                                    flex: 1
						                                },



						                                {
						                                    text: 'Descripción',
						                                    dataIndex: 'descripcion',
						                                    flex: 1
						                                },
						                                {
						                                    text: 'Estado Lote',
						                                    dataIndex: 'lot_estado',
						                                    loocked : true,
						                                    width: 100,
						                                    align: 'center',
						                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
						                                        //console.log(record);
						                                        metaData.style = "padding: 0px; margin: 0px";
						                                        if(parseInt(record.get('nivel'))==1){
							                                        var estado = (record.get('lot_estado')=='LT')?'baggage_cart_box.png':'contraer.png';
							                                        var qtip = (record.get('lot_estado')=='LT')?'Lotizado.':'Lote en otro Estado.';
						                                        }else{
						                                        	var estado = (record.get('lot_estado')=='LT')?'basket_put_gray.png':'basket_put.png';
							                                        var qtip = (record.get('lot_estado')=='LT')?'Folder Vacio.':'Folder en otro Estado.';
						                                        }
						                                        

						                                        return global.permisos({
						                                            type: 'link',
						                                            id_menu: ireturn.id_menu,
						                                            icons:[
						                                                {id_serv: 7, img: estado, qtip: qtip, js: ""}
						                                            ]
						                                        });
						                                    }
						                                },
						                                {
						                                    text: 'Fecha y Hora',
						                                    dataIndex: 'fecha',
						                                    width: 180,
						                                    align: 'center'
						                                },

														{
											                xtype: 'checkcolumn',
											                header: 'Done',
											                dataIndex: 'done',
											                width: 55,
											                stopSelection: false,
											                menuDisabled: true/*,
											                listeners: {
											                	 checkchange: 'onCheckcolumnCheckChange'
											                	}*/
											            }
											        ],
							                        hideItemsReadFalse: function () {
													    var me = this,
													        items = me.getReferences().treelistRef.itemMap;


													    for(var i in items){
													        if(items[i].config.node.data.read == false){
													            items[i].destroy();
													        }
													    }
													},
							                        trackMouseOver: false,
							                        listeners:{
							                            afterrender: function(obj){
							                                
							                            },
														beforeselect:function(obj, record, index, eOpts ){

														},
	
												        checkchange: function( node, checked, eOpts ){
												            if(node.hasChildNodes()){
												                node.eachChild(function(childNode){
												                    childNode.set('checked', checked);
												                });
												            }
												        }
												    



							                        }
							                    }
											]
										}
									]
									
								}
							]
						}
					],
					listeners:{
						beforerender: function(obj, opts){
	                        global.state_item_menu(ireturn.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,ireturn.id_menu);
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(ireturn.id_menu, false);
	                    }
					}

				}).show();
			},
			getImagen:function(param){

			},
			setEditLote:function(index,op){
				var rec = Ext.getCmp(ireturn.id + '-grid').getStore().getAt(index);
				ireturn.id_lote=rec.data.id_lote;
				var shi_codigo = Ext.getCmp(ireturn.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(ireturn.id+'-cbx-contrato').getValue();
				if(rec.data.shi_codigo!=shi_codigo){
					Ext.getCmp(ireturn.id+'-cbx-cliente').setValue(rec.data.shi_codigo);
					Ext.getCmp(ireturn.id+'-cbx-contrato').setValue('');
					ireturn.getContratos(rec.data.shi_codigo);
				}
				Ext.getCmp(ireturn.id+'-cbx-contrato').setValue(rec.data.fac_cliente);
				ireturn.shi_codigo=rec.data.shi_codigo;
				ireturn.fac_cliente=rec.data.fac_cliente;

				ireturn.opcion=op;
				if(op!='D'){
					Ext.getCmp(ireturn.id+'-txt-nombre').setValue(rec.data.nombre);
					Ext.getCmp(ireturn.id+'-txt-descripcion').setValue(rec.data.descripcion);
				  	Ext.getCmp(ireturn.id+'-txt-estado').setValue(rec.data.estado);
				  	Ext.getCmp(ireturn.id+'-txt-tot_folder').setValue(rec.data.tot_folder);


				  	Ext.getCmp(ireturn.id+'-txt-nombre').focus(true);

				}else{
					ireturn.set_lotizer(2,'¿Está seguro de Desactivar?');
				}
			},
			set_lotizer_clear:function(){
			  	ireturn.id_lote=0;
			  	ireturn.shi_codigo=0;
				ireturn.fac_cliente=0;
				ireturn.opcion='I';
				Ext.getCmp(ireturn.id+'-cbx-cliente').focus(true);
			},
			setValidaLote:function(){
				if(ireturn.opcion=='I' || ireturn.opcion=='U'){
					var shi_codigo = Ext.getCmp(ireturn.id+'-cbx-cliente').getValue();
					if(shi_codigo== null || shi_codigo==''){
			            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			        ireturn.shi_codigo=shi_codigo;
					var fac_cliente = Ext.getCmp(ireturn.id+'-cbx-contrato').getValue();
					if(fac_cliente== null || fac_cliente==''){
			            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			        ireturn.fac_cliente=fac_cliente;
					var nombre = Ext.getCmp(ireturn.id+'-txt-nombre').getValue();
					if(nombre== null || nombre==''){
			            global.Msg({msg:"Ingrese un nombre por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			        var estado = Ext.getCmp(ireturn.id+'-txt-estado').getValue();
			        if(estado== null || estado==''){
			            global.Msg({msg:"Ingrese un estado por favor.",icon:2,fn:function(){}});
			            return false; 
			        }
				  	var total = Ext.getCmp(ireturn.id+'-txt-tot_folder').getValue();
				  	if(total== null || total==0 || total==''){
			            global.Msg({msg:"Ingrese el total de folderes por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			    }
		        return true;
			},
			set_lotizer:function(ico,msn){
				if(!ireturn.setValidaLote())return;
				global.Msg({
                    msg: msn,
                    icon: ico,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
	                        Ext.getCmp(ireturn.id+'-tab').el.mask('Cargando…', 'x-mask-loading');
	                        Ext.Ajax.request({
								url: ireturn.url + 'set_lotizer/',
								params:{
									vp_op: ireturn.opcion,
									vp_shi_codigo:ireturn.shi_codigo,
									vp_fac_cliente:ireturn.fac_cliente,
			                        vp_id_lote:ireturn.id_lote,
			                        vp_nombre:Ext.getCmp(ireturn.id+'-txt-nombre').getValue(),
			                        vp_descripcion:Ext.getCmp(ireturn.id+'-txt-descripcion').getValue(),
			                        vp_tipdoc:Ext.getCmp(ireturn.id+'-txt-tipdoc').getValue(),
			                        vp_lote_fecha:Ext.getCmp(ireturn.id+'-txt-fecha').getValue(),
			                        vp_ctdad:Ext.getCmp(ireturn.id+'-txt-tot_folder').getValue(),
			                        vp_estado:Ext.getCmp(ireturn.id+'-txt-estado').getValue()
								},
								success:function(response,options){
									var res = Ext.decode(response.responseText);
									Ext.getCmp(ireturn.id+'-tab').el.unmask();
									global.Msg({
		                                msg: res.msn,
		                                icon: parseInt(res.error),
		                                buttons: 1,
		                                fn: function(btn){
		                                    if(parseInt(res.error)==1){
		                                    	ireturn.getReloadGridlotizer('');
		                                    	ireturn.set_lotizer_clear();
		                                    }
		                                }
		                            });
				    			}
				    		});
				    	}
		            }
                });
			},
			getContratos:function(shi_codigo){
				Ext.getCmp(ireturn.id+'-cbx-contrato').getStore().removeAll();
				Ext.getCmp(ireturn.id+'-cbx-contrato').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo},
	                callback:function(){

	                }
	            });
			},
			getReloadGridlotizer:function(name){
				ireturn.set_lotizer_clear();
				var shi_codigo = Ext.getCmp(ireturn.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(ireturn.id+'-cbx-contrato').getValue();
				var lote = Ext.getCmp(ireturn.id+'-txt-lote').getValue();
				var name = Ext.getCmp(ireturn.id+'-txt-lotizer').getValue();
				var estado = Ext.getCmp(ireturn.id+'-txt-estado-filter').getValue();
				var fecha = Ext.getCmp(ireturn.id+'-txt-fecha-filtro').getRawValue();

				if(shi_codigo== null || shi_codigo==''){
		            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				if(fac_cliente== null || fac_cliente==''){
		            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
		            return false;
		        }
		        if(lote== null || lote==''){
		        	lote=0;
		        }
				if(fecha== null || fecha==''){
		            global.Msg({msg:"Ingrese una fecha de busqueda por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				Ext.getCmp(ireturn.id + '-grid').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_lote:lote,vp_lote_estado:'LT',vp_name:name,fecha:fecha,vp_estado:estado},
	                callback:function(){

	                }
	            });
			},
			getReloadGridlotizer2:function(id_lote){
				Ext.getCmp(ireturn.id+'-form').el.mask('Cargando…', 'x-mask-loading');

				Ext.getCmp(ireturn.id + '-grid-lotizer').getStore().load(
	                {params: {vp_id_lote:id_lote},
	                callback:function(){
	                	Ext.getCmp(ireturn.id+'-form').el.unmask();
	                }
	            });
			},
			setNuevo:function(){

				Ext.getCmp(ireturn.id+'-txt-nombre').setValue('');
				Ext.getCmp(ireturn.id+'-txt-nombre').setReadOnly(false);
				Ext.getCmp(ireturn.id+'-txt-tipdoc').setValue('');
				Ext.getCmp(ireturn.id+'-txt-tipdoc').setReadOnly(false);
				Ext.getCmp(ireturn.id+'-txt-fecha').setValue('');
				Ext.getCmp(ireturn.id+'-txt-fecha').setReadOnly(false);
				Ext.getCmp(ireturn.id+'-txt-estado').setValue('');
				Ext.getCmp(ireturn.id+'-txt-estado').setReadOnly(false);
				Ext.getCmp(ireturn.id+'-txt-tot_folder').setValue('');
				Ext.getCmp(ireturn.id+'-txt-tot_folder').setReadOnly(false);
				Ext.getCmp(ireturn.id+'-txt-nombre').focus();
			},

			set_return:function(ico,msn,storeReturn){
				
				global.Msg({
                    msg: msn,
                    icon: ico,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){

						    storeReturn.each(function(record,index) {
									        ireturn.nombre = record.data.nombre;
									        ireturn.id_lote = record.data.id_lote;
									        ireturn.id_det = record.data.id_det;

					                        Ext.getCmp(ireturn.id+'-tab').el.mask('Cargando…', 'x-mask-loading');
					                        Ext.Ajax.request({
												url: ireturn.url + 'set_return/',
												params:{
							                        vp_nombre:ireturn.nombre,
							                        vp_id_lote:ireturn.id_lote,
							                        vp_id_det:ireturn.id_det
												},
												success:function(response,options){
													var res = Ext.decode(response.responseText);
													Ext.getCmp(ireturn.id+'-tab').el.unmask();
													global.Msg({
						                                msg: res.msn,
						                                icon: parseInt(res.error),
						                                buttons: 1,
						                                fn: function(btn){
						                                    if(parseInt(res.error)==1){
						                                    	if (ireturn.opcion == 'U' || ireturn.opcion == 'I') {

						                                    	}
						                                    	ireturn.getReloadGridlotizer('');
						                                    	ireturn.set_lotizer_clear();
						                                    }
						                                }
						                            });
								    			}

							});



				    		});
				    	}
		            }
                });
			},

			onCheckcolumnCheckChange: function(checkcolumn, rowIndex, checked, eOpts) {
			    var view = this.getView();
			    var item = this.getStore().data.items[rowIndex];
			    var columnName = checkcolumn.dataIndex;

			    // User unchecked a row: refresh the view
			    if(!checked){
			        view.refresh();
			        return;
			    }

			    // User checked a row: unselect all parents
			    var parentNode = item.parentNode;
			    while(typeof parentNode != 'undefined' && parentNode !== null && !parentNode.data.root){
			        parentNode.set(columnName, false);
			        parentNode = parentNode.parentNode;
			    }

			    // Then uncheck all childs (recusif)
			    (function doChild(children){
			        if(typeof children == 'undefined' || children === null || children.length <= 0)
			            return;

			        for(var i=0; i<children.length; i++){
			            children[i].set(columnName, false);
			            doChild(children[i].childNodes);    // <= recursivity
			        }
			    })(item.childNodes);

			    view.refresh();
			}			
			,
			getFormMant:function(arrDataCollection){

			Ext.define('TestModel', {
			    extend: 'Ext.data.Model',
		        fields: [
		            { name: "nombre", type: "string" },
		            { name: "id_lote", type: "int"  },
		            { name: "id_det", type: "int"  },
		        ]
			});

			var store_devolver = Ext.create('Ext.data.ArrayStore', {
		        autoLoad: true,
		        model:TestModel,
		        data: arrDataCollection
		    });

				Ext.create('Ext.window.Window',{
	                id:ireturn.id+'-win-form',
	                plain: true,
	                title:'Devolución',
	                icon: '/images/icon/if_General_Office_36_2530817.png',
	                height: 200,
	                width: 450,
	                resizable:false,
	                modal: true,
	                border:false,
	                closable:true,
	                padding:20,
	                items:[
	                	{
	                        xtype: 'grid',
	                        id:ireturn.id+'-grid-return-form',
	                        store:store_devolver,
	                        columnLines: true,
	                        columns:{
	                            items:[
	                                {
	                                    text: 'Nombre',
	                                    dataIndex: 'nombre',
	                                    flex: 1
	                                },
	                                	                                {
	                                    text: 'id_lote',
	                                    dataIndex: 'id_lote',
	                                    flex: 1
	                                },
	                                	                                {
	                                    text: 'id_det',
	                                    dataIndex: 'id_det',
	                                    flex: 1
	                                }
	                                ],	
			                            defaults:{
			                                menuDisabled: true
			                            }
			                        },
			                        viewConfig: {
			                            stripeRows: true,
			                            enableTextSelection: false,
			                            markDirty: false
			                        },
			                        trackMouseOver: false,
			                        listeners:{
			                            afterrender: function(obj){
			                            }
			                        }



	                    }
	                ],
	                bbar:[       
	                    '->',
	                    '-',
	                    {
	                        xtype:'button',
	                        text: 'Devolver',
	                        icon: '/images/icon/save.png',
	                        listeners:{
	                            beforerender: function(obj, opts){
								},
	                            click: function(obj, e){

									Ext.getCmp(ireturn.id+'-win-form').el.mask('Cargando…', 'x-mask-loading');
									ireturn.set_return(3,'¿Está seguro de devolver?',store_devolver);
									Ext.getCmp(ireturn.id+'-win-form').close();	

	                            }
	                        }
	                    },
	                    '-',
	                    {
	                        xtype:'button',
	                        text: 'Salir',
	                        icon: '/images/icon/get_back.png',
	                        listeners:{
	                            beforerender: function(obj, opts){
	                            },
	                            click: function(obj, e){
	                                Ext.getCmp(ireturn.id+'-win-form').close();
	                            }
	                        }
	                    },
	                    '-'
	                ],
	                listeners:{
	                    'afterrender':function(obj, e){ 

	                    },
	                    'close':function(){

	                    }
	                }
	            }).show().center();
			}

		}
		Ext.onReady(ireturn.init,ireturn);
	}else{
		tab.setActiveTab(ireturn.id+'-tab');
	}
</script>