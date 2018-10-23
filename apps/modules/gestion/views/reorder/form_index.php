<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('reorder-tab')){
		var reorder = {
			id:'reorder',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/reorder/',
			opcion:'I',
			id_lote:0,
			shi_codigo:0,
			fac_cliente:0,
			lote:0,
			paramsStore:{},
			init:function(){
				Ext.tip.QuickTipManager.init();

				Ext.define('Task', {
				    extend: 'Ext.data.TreeModel',
				    fields: [
				        {name: 'hijo', type: 'string'},
				        {name: 'padre', type: 'string'},
				        {name: 'id_lote', type: 'string'},
				        {name: 'shi_codigo', type: 'string'},
				        {name: 'fac_cliente', type: 'string'},
				        {name: 'lot_estado', type: 'string'},
	                    {name: 'tipdoc', type: 'string'},
	                    {name: 'nombre', type: 'string'},
	                    {name: 'lote_nombre', type: 'string'},
	                    {name: 'descripcion', type: 'string'},
	                    {name: 'path', type: 'string'},
	                    {name: 'img', type: 'string'},
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
	                    url: reorder.url+'get_list_lotizer/'//,
	                    //reader:{
	                    //    type: 'json'//,
	                    //    //rootProperty: 'data'
	                    //}
	                },
	                folderSort: true,
	                listeners:{
	                	beforeload: function (store, operation, opts) {
	                		store.proxy.extraParams = reorder.paramsStore;
					        /*Ext.apply(operation, {
					            params: {
					                to: 'test1',
		    						from: 'test2'
					            }
					       });*/
					    },
	                    load: function(obj, records, successful, opts){
	                 		Ext.getCmp(reorder.id + '-grid-reorder').doLayout();
	                 		//Ext.getCmp(lotizer.id + '-grid').getView().getRow(0).style.display = 'none';
	                 		storeTree.removeAt(0);
	                 		Ext.getCmp(reorder.id + '-grid-reorder').collapseAll();
		                    Ext.getCmp(reorder.id + '-grid-reorder').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                    });
		                    Ext.getCmp(reorder.id + '-grid-reorder').expandAll();
	                    }
	                }
	            });

				var store_history = Ext.create('Ext.data.Store',{
	                fields: [
	                    {name: 'id_estado', type: 'string'},
	                    {name: 'id_lote', type: 'string'},
	                    {name: 'shi_codigo', type: 'string'},
	                    {name: 'lot_estado', type: 'string'},                    
	                    {name: 'usr_nombre', type: 'string'},
	                    {name: 'fecact', type: 'string'}
	                ],
	                autoLoad:true,
	                proxy:{
	                    type: 'ajax',
	                    url: reorder.url+'get_list_history/',
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
	                    url: reorder.url+'get_list_shipper/',
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
	                    url: reorder.url+'get_list_contratos/',
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

	            var store_plantillas = Ext.create('Ext.data.Store',{
	                fields: [
	                    {name: 'cod_plantilla', type: 'string'},
				        {name: 'shi_codigo', type: 'string'},
				        {name: 'fac_cliente', type: 'string'},
				        {name: 'nombre', type: 'string'},
	                    {name: 'cod_formato', type: 'string'},
	                    {name: 'tot_trazos', type: 'string'},
	                    {name: 'path', type: 'string'},
	                    {name: 'img', type: 'string'},
	                    {name: 'pathorigen', type: 'string'},
	                    {name: 'imgorigen', type: 'string'},
	                    {name: 'texto', type: 'string'},
	                    {name: 'estado', type: 'string'},
	                    {name: 'fecha', type: 'string'},
	                    {name: 'usuario', type: 'string'},
	                    {name: 'width', type: 'string'},
	                    {name: 'height', type: 'string'},
	                    {name: 'width_formato', type: 'string'},
	                    {name: 'height_formato', type: 'string'},
	                    {name: 'formato', type: 'string'}
	                ],
	                autoLoad:false,
	                proxy:{
	                    type: 'ajax',
	                    url: reorder.url+'get_ocr_plantillas/',
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

				var store_trazos = Ext.create('Ext.data.Store',{
	                fields: [
	                    {name: 'cod_trazo', type: 'string'},
				        {name: 'cod_plantilla', type: 'string'},
				        {name: 'nombre', type: 'string'},
				        {name: 'tipo', type: 'string'},
	                    {name: 'x', type: 'string'},
	                    {name: 'y', type: 'string'},
	                    {name: 'w', type: 'string'},
	                    {name: 'h', type: 'string'},
	                    {name: 'path', type: 'string'},
	                    {name: 'img', type: 'string'},
	                    {name: 'texto', type: 'string'},
	                    {name: 'estado', type: 'string'},
	                    {name: 'usuario', type: 'string'},
	                    {name: 'fecha', type: 'string'}
	                ],
	                autoLoad:false,
	                proxy:{
	                    type: 'ajax',
	                    url: reorder.url+'get_ocr_trazos/',
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

				var myData = [
				    ['databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color']
				];
				var store_estados = Ext.create('Ext.data.ArrayStore', {
			        storeId: 'estado',
			        autoLoad: false,
			        data: myData,
			        fields: ['clase_box1', 'clase_box2', 'clase_box3', 'clase_box4', 'clase_box5', 'clase_box6']
			    });

			    var myDataIMAGEN = [
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color']
				];
				var store_imagen = Ext.create('Ext.data.ArrayStore', {
			        storeId: 'imagen',
			        autoLoad: false,
			        data: myDataIMAGEN,
			        fields: ['clase_box1']
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
				var myDataSearch = [
					['L','N° Lote'],
					['N','Nombre Lote'],
				    ['A','Nombre Archivo'],
				    ['G','Nombre Archivo Generado'],
				    ['O','Full Text OCR'],
				    ['T','Texto en Trazo OCR']
				];
				var store_search = Ext.create('Ext.data.ArrayStore', {
			        storeId: 'search',
			        autoLoad: true,
			        data: myDataSearch,
			        fields: ['code', 'name']
			    });
				var panel = Ext.create('Ext.form.Panel',{
					id:reorder.id+'-form',
					bodyStyle: 'background: transparent',
					border:false,
					layout:'border',
					defaults:{
						border:false
					},
					//tbar:[],
					items:[
						{
							region:'center',
							layout:'fit',
							border:false,
							items:[


								{
			                        xtype: 'treepanel',
			                        //collapsible: true,
							        useArrows: true,
							        rootVisible: true,
							        multiSelect: true,
							        //root:'Task',
			                        id: reorder.id + '-grid-reorder',
			                        //height: 370,
			                        //reserveScrollbar: true,
			                        //rootVisible: false,
			                        //store: store,
			                        //layout:'fit',
			                        columnLines: true,
			                        store: storeTree,
						            columns: [
							            /*{
							                xtype: 'treecolumn', //this is so we know which column will show the tree
							                text: 'Task',
							                flex: 2,
							                sortable: true,
							                dataIndex: 'task'
							            },*/
							            {
							            	xtype: 'treecolumn',
		                                    text: 'Nombre',
		                                    dataIndex: 'lote_nombre',
		                                    sortable: true,
		                                    flex:1
		                                },
		                                {
		                                    text: 'Estado',
		                                    dataIndex: 'estado',
		                                    loocked : true,
		                                    width: 50,
		                                    align: 'center',
		                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
		                                        //console.log(record);
		                                        metaData.style = "padding: 0px; margin: 0px";
		                                        var estado = (record.get('estado')=='A')?'check-circle-green-16.png':'check-circle-red.png';
		                                        var qtip = (record.get('estado')=='A')?'Estado del Lote Activo.':'Estado del Lote Inactivo.';
		                                        return global.permisos({
		                                            type: 'link',
		                                            id_menu: reorder.id_menu,
		                                            icons:[
		                                                {id_serv: 8, img: estado, qtip: qtip, js: ""}
		                                            ]
		                                        });
		                                    }
		                                }
							        ],
			                        /*viewConfig: {
			                            stripeRows: true,
			                            enableTextSelection: false,
			                            markDirty: false
			                        },*/
			                        viewConfig: {
						                plugins: {
						                    ptype: 'treeviewdragdrop',
						                    containerScroll: true
						                }
						            },
			                        hideItemsReadFalse: function () {
									    var me = this,items = me.getReferences().treelistRef.itemMap;
									    for(var i in items){
									        if(items[i].config.node.data.read == false){
									            items[i].destroy();
									        }
									    }
									},
			                        trackMouseOver: false,
			                        listeners:{
			                            afterrender: function(obj){
			                                //reorder.getImagen('default.png');
			                                Ext.getCmp(reorder.id + '-grid-reorder').getStore().removeAll();
											Ext.getCmp(reorder.id + '-grid-reorder').getView().refresh();
			                            },
										beforeselect:function(obj, record, index, eOpts ){
											reorder.getStatusPanel(record.get('lot_estado'));
											reorder.getHistory(record.get('id_lote'));

											//document.getElementById('imagen-reorder').innerHTML='<img src="'+record.get('path')+record.get('img')+'" width="100%" height="100%" />'
											
											

											var image = document.getElementById('imagen-reorder-img');
											var downloadingImage = new Image();
											downloadingImage.onload = function(){
											    image.src = this.src;   
											    Ext.getCmp(reorder.id + '-panel-imagen').doLayout();
											};
											downloadingImage.src = record.get('path')+record.get('img');
											

										}
			                        }
			                    }
							]
						}
					]
				});

				
				var win = Ext.create('Ext.window.Window',{
					id:reorder.id+'-win',
					title:'RE-ORDENAR',
					height:600,
					width:400,
					resizable:false,
					//closable:false,
					//minimizable:true,
					plaint:true,
					constrain:true,
					constrainHeader:true,
					//renderTo:Ext.get(gtransporte.id+'cont_map'),
					header:true,
					border:false,
					layout:{
						type:'fit'
					},
					modal:true,
					items:[panel],
					listeners:{
						show:function(window,eOpts){
							//window.alignTo(Ext.get(gtransporte.id+'Mapsa'),'bl-bl');
						},
						minimize:function(window,opts){
							/*window.collapse();
							window.setWidth(100);
							window.alignTo(Ext.get(gtransporte.id+'Mapsa'), 'bl-bl');*/
						},
						beforerender:function(obj,opts){
							//reorder.call_origen();
						}
					}
				}).show();
			},
			getReloadGridreorder:function(){
				//Ext.getCmp(reorder.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				reorder.lote=0;
				Ext.getCmp(reorder.id + '-grid-history').getStore().removeAll();
				reorder.getStatusPanel('N');
				var vp_op = Ext.getCmp(reorder.id+'-filter-por').getValue();
				var shi_codigo = Ext.getCmp(reorder.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(reorder.id+'-cbx-contrato').getValue();

				var lote = 0;//Ext.getCmp(reorder.id+'-txt-lote').getValue();

				var vp_cod_trazo=Ext.getCmp(reorder.id+'-filter-trazos').getValue();
				var name = Ext.getCmp(reorder.id+'-txt-reorder').getValue();



				var estado = Ext.getCmp(reorder.id+'-txt-estado-filter').getValue();
				var fecha = Ext.getCmp(reorder.id+'-txt-fecha-filtro').getRawValue();

				if(shi_codigo== null || shi_codigo==''){
		            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				if(fac_cliente== null || fac_cliente==''){
		            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
		            return false;
		        }

		        if(vp_op=='L'){
					lote=name;
					name='';
				}

		        if(lote== null || lote==''){
		        	if(vp_op=='L'){
		        		global.Msg({msg:"Ingrese un Lote.",icon:2,fn:function(){}});
		            	return false;
		        	}
		        	lote=0;
		        }
		        if(vp_op=='T'){
			        if(vp_cod_trazo== null || vp_cod_trazo==''){
			            global.Msg({msg:"Seleccione un Trazo por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			    }else{
			    	vp_cod_trazo=0;
			    }
				/*
				if(fecha== null || fecha==''){
		            global.Msg({msg:"Ingrese una fecha de busqueda por favor.",icon:2,fn:function(){}});
		            return false;
		        }*/
		        Ext.getCmp(reorder.id + '-grid-reorder').getStore().removeAll();
		        Ext.getCmp(reorder.id + '-grid-reorder').getView().refresh();
		        reorder.paramsStore={vp_op:vp_op,vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_lote:lote,vp_cod_trazo:vp_cod_trazo,vp_lote_estado:'',vp_name:name,fecha:fecha,vp_estado:estado};
		        Ext.getCmp(reorder.id + '-grid-reorder').getStore().load(
	                {params: reorder.paramsStore,
	                callback:function(){
	                	//Ext.getCmp(reorder.id+'-form').el.unmask();
	                }
	            });
			}

		}
		Ext.onReady(reorder.init,reorder);
	}else{
		tab.setActiveTab(reorder.id+'-tab');
	}
</script>