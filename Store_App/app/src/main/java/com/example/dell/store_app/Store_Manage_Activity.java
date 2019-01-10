package com.example.dell.store_app;

import android.app.AlertDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.drawable.ColorDrawable;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.CertificatePinner;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Store_Manage_Activity extends AppCompatActivity {

    private ArrayList<Store_Manage> data = new ArrayList<Store_Manage>();
    private String token = Login_Token.token;
    private String hostname = "luxexpress.cf";

    CertificatePinner certificatePinner = new CertificatePinner.Builder()
            .add(hostname, "sha256/MPTkwqvsxxFu44jSBUkloPwzP8VQwYEaGybVkEmRuww=")
            .add(hostname, "sha256/YLh1dUR9y6Kja30RrAn7JKnbQG/uEtLMkBgFF2Fuihg=")
            .add(hostname, "sha256/Vjs8r4z+80wjNcr1YKepWQboSIRi63WsWXhIMN+eWys=")
            .build();

    OkHttpClient client = new OkHttpClient.Builder()
            .certificatePinner(certificatePinner)
            .build();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_store_manage);

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("your_input", "your_value")
                .build();

        Request request = new Request.Builder()
                .url("https://luxexpress.cf/api/store/showOrder")
                //.url(" http://192.168.0.132:8000/api/store/showOrder")
                .post(requestBody)
                .addHeader("Authorization", "Bearer " + token)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                e.printStackTrace();
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                final String yourResponse = response.body().string();

                if(response.isSuccessful()){
                    Log.w("Add_Activity","Add success");
                    //Toast.makeText(Add_Activity.this, "Add success", Toast.LENGTH_SHORT).show();

                    Store_Manage_Activity.this.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            JSONObject Jobject = null;
                            try {
                                ListView lv_store_mange = findViewById(R.id.list_view_store_manage);
                                Jobject = new JSONObject(yourResponse);

                                JSONArray Jarray = Jobject.getJSONArray("data");

                                for (int i = 0; i < Jarray.length(); i++) {
                                    JSONObject object = Jarray.getJSONObject(i);
                                    Log.w("myApp", object.toString());
                                    String billOfLading = object.getString("billOfLading");
                                    String address = object.getString("addressReceiver");
                                    String idOrder = object.getString("idOrder");

                                    data.add(new Store_Manage(billOfLading,address,idOrder));
                                }

                                lv_store_mange.setAdapter(new Store_Manage_Adapter(Store_Manage_Activity.this, R.layout.list_store_manage_item, data));
                                Log.w("Add_Activitye eponse","Add eponse "+ yourResponse.toString());

                            } catch (JSONException e) {
                                e.printStackTrace();
                                Log.w("Add_Activitye error","Add faild "+yourResponse.toString());
                                Log.w("Add_Activitye error","Add faild "+e.toString());
                            }

                        }
                    });


                }else{
                    Log.w("Add_Activity","Add faild "+yourResponse.toString());
                }

            }
        });



    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu){
        getMenuInflater().inflate(R.menu.menu_store, menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item){
        Intent intent;
        switch(item.getItemId()){
            case R.id.menu_item_add_order:

                intent = new Intent(getBaseContext(), Add_Activity.class);
                startActivity(intent);

                break;
            case R.id.menu_item_manage_order:

                intent = new Intent(getBaseContext(), Store_Manage_Activity.class);
                startActivity(intent);
                break;

            case R.id.menu_item_home:

                intent = new Intent(getBaseContext(), Home_Activity.class);
                startActivity(intent);
                break;

        }
        return super.onOptionsItemSelected(item);
    }


    private class Store_Manage_Adapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<Store_Manage> arrayStoreManage;

        public Store_Manage_Adapter(Context context, int layout, List<Store_Manage> store_manage_List){
            myContext = context;
            myLayout = layout;
            arrayStoreManage = store_manage_List;
        }

        @Override
        public int getCount() {
            return arrayStoreManage.size();
        }

        @Override
        public Object getItem(int position) {
            return null;
        }

        @Override
        public long getItemId(int position) {
            return 0;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {

            LayoutInflater inflater = (LayoutInflater) myContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(myLayout, null);

            TextView bill_of_lading = (TextView) convertView.findViewById(R.id.bill_of_lading);
            TextView address = (TextView) convertView.findViewById(R.id.address);

            Button btn_edit = (Button) convertView.findViewById(R.id.btn_edit);

            bill_of_lading.setText(arrayStoreManage.get(position).getBill_of_lading());
            address.setText(arrayStoreManage.get(position).getAddress());

            LinearLayout lnlo_store_manage = (LinearLayout) convertView.findViewById (R.id.lnlo_store_manage);

            final int vitri = position;

            lnlo_store_manage.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    //Toast.makeText(Store_Manage_Activity.this, "Add success", Toast.LENGTH_SHORT).show();
                    OkHttpClient client = new OkHttpClient();

                    RequestBody requestBody = new MultipartBody.Builder()
                            .setType(MultipartBody.FORM)
                            .addFormDataPart("id_order", arrayStoreManage.get(vitri).getId_order())
                            .build();

                    Request request = new Request.Builder()
                            //.url(" http://192.168.0.132:8000/api/store/showDetailOrder")
                            .url("https://luxexpress.cf/api/store/showDetailOrder")
                            .post(requestBody)
                            .addHeader("Authorization", "Bearer " + token)
                            .build();

                    client.newCall(request).enqueue(new Callback() {
                        @Override
                        public void onFailure(Call call, IOException e) {
                            e.printStackTrace();
                        }

                        @Override
                        public void onResponse(Call call, Response response) throws IOException {
                            final String yourResponse = response.body().string();

                            if (response.isSuccessful()) {

                                Store_Manage_Activity.this.runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        JSONObject Jobject = null;
                                        try {
                                            ListView lv_order_detail = new ListView( Store_Manage_Activity.this);
                                            ColorDrawable blue = new ColorDrawable(ContextCompat.getColor( Store_Manage_Activity.this, R.color.colorBlue));
                                            lv_order_detail.setDivider(blue);
                                            lv_order_detail.setDividerHeight(5);

                                            Log.w("myApp", "BLue : " + blue.toString());

                                            ArrayList<OrderDetail> data_detail = new ArrayList<OrderDetail>();
                                            Jobject = new JSONObject(yourResponse);

                                            String phoneStore = null;
                                            String addressStore = null;
                                            String billOfLading = null;
                                            String nameProduct = null;
                                            String number_of_store = null;
                                            String nameReceiver = null;
                                            String phoneReceiver = null;

                                            JSONArray Jarray = Jobject.getJSONArray("data");

                                            if (Jarray.length() > 0) {

                                                for (int i = 0; i < Jarray.length(); i++) {
                                                    JSONObject object = Jarray.getJSONObject(i);
                                                    Log.w("myApp", "Detail: " + object.toString());

                                                    //String phoneStore = object.getString("phoneStore");
                                                    phoneStore = "123789";
                                                    addressStore = object.getString("addressStore");
                                                    billOfLading = object.getString("billOfLading");
                                                    nameProduct = object.getString("nameProduct");
                                                    //String number_of_store = object.getString("number_of_store");
                                                    number_of_store = "2";
                                                    nameReceiver = object.getString("nameReceiver");
                                                    phoneReceiver = object.getString("phoneReceiver");

                                                    data_detail.add(new OrderDetail(phoneStore, addressStore, billOfLading, nameProduct, number_of_store, nameReceiver,phoneReceiver));
                                                }
                                                lv_order_detail.setAdapter(new OrderDetailAdapter(Store_Manage_Activity.this, R.layout.info_order_dialog, data_detail));

//                                                Dialog dialog = new Dialog(Order_Activity.this, R.style.Theme_Dialog);
//                                                dialog.setTitle("Chi tiết đơn hàng");
//                                                dialog.;
                                                //AlertDialog.Builder builder = new AlertDialog.Builder(new ContextThemeWrapper(Order_Activity.this, R.style.Theme_Dialog));

                                                AlertDialog.Builder builder = new AlertDialog.Builder(Store_Manage_Activity.this,AlertDialog.THEME_HOLO_LIGHT);
                                                builder.setPositiveButton("OK" ,null);
                                                builder.setView(lv_order_detail);
                                                AlertDialog dialog = builder.create();
                                                dialog.setTitle("Chi tiết đơn hàng");
                                                dialog.show();

                                            } else {
                                                AlertDialog.Builder builder = new AlertDialog.Builder(Store_Manage_Activity.this,AlertDialog.THEME_HOLO_LIGHT);
                                                builder.setPositiveButton("OK" ,null);
                                                AlertDialog dialog = builder.create();
                                                dialog.setTitle("Chi tiết đơn hàng");
                                                dialog.setMessage("Không có hóa dơn chi tiết");
                                                dialog.show();
                                            }


                                        } catch (JSONException e) {
                                            e.printStackTrace();
                                        }

                                    }
                                });
                            } else {

                            }


                        }
                    });
                }
            });

            btn_edit.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Intent intent = new Intent(Store_Manage_Activity.this,Edit_Activity.class);
                    Log.w("Add_Activity", "Add faild " + vitri);
                    Log.w("Add_Activity", "Add faild " + arrayStoreManage.get(vitri).getId_order());

                    intent.putExtra("id_order",arrayStoreManage.get(vitri).getId_order());
                    startActivity(intent);
                }
            });

            return convertView;
        }
    }


    private class Store_Manage{


        private String bill_of_lading;
        private String address;
        private String id_order;

        public Store_Manage(String bill_of_lading, String address, String id_order) {
            this.bill_of_lading = bill_of_lading;
            this.address = address;
            this.id_order = id_order;
        }

        public String getBill_of_lading() {
            return bill_of_lading;
        }

        public void setBill_of_lading(String bill_of_lading) {
            this.bill_of_lading = bill_of_lading;
        }

        public String getAddress() {
            return address;
        }

        public void setAddress(String address) {
            this.address = address;
        }

        public String getId_order() {
            return id_order;
        }

        public void setId_order(String id_order) {
            this.id_order = id_order;
        }

//        public String getBill_of_lading() {
//            return bill_of_lading;
//        }
//
//        public void setBill_of_lading(String bill_of_lading) {
//            this.bill_of_lading = bill_of_lading;
//        }
//
//        public String getAddress() {
//            return address;
//        }
//
//        public void setAddress(String address) {
//            this.address = address;
//        }
//
//        Store_Manage(String bill_of_lading, String address){
//            this.bill_of_lading = bill_of_lading;
//            this.address = address;
//        }

    }
    private class OrderDetail {

        private String phoneStore;
        private String addressStore;
        private String billOfLading;
        private String nameProduct;
        private String number_of_store;
        private String nameReceiver;
        private String phoneReceiver;

        public OrderDetail(String phoneStore, String addressStore, String billOfLading, String nameProduct, String number_of_store, String nameReceiver, String phoneReceiver) {
            this.phoneStore = phoneStore;
            this.addressStore = addressStore;
            this.billOfLading = billOfLading;
            this.nameProduct = nameProduct;
            this.number_of_store = number_of_store;
            this.nameReceiver = nameReceiver;
            this.phoneReceiver = phoneReceiver;
        }

        public String getPhoneStore() {
            return phoneStore;
        }

        public void setPhoneStore(String phoneStore) {
            this.phoneStore = phoneStore;
        }

        public String getAddressStore() {
            return addressStore;
        }

        public void setAddressStore(String addressStore) {
            this.addressStore = addressStore;
        }

        public String getBillOfLading() {
            return billOfLading;
        }

        public void setBillOfLading(String billOfLading) {
            this.billOfLading = billOfLading;
        }

        public String getNameProduct() {
            return nameProduct;
        }

        public void setNameProduct(String nameProduct) {
            this.nameProduct = nameProduct;
        }

        public String getNumber_of_store() {
            return number_of_store;
        }

        public void setNumber_of_store(String number_of_store) {
            this.number_of_store = number_of_store;
        }

        public String getNameReceiver() {
            return nameReceiver;
        }

        public void setNameReceiver(String nameReceiver) {
            this.nameReceiver = nameReceiver;
        }

        public String getPhoneReceiver() {
            return phoneReceiver;
        }

        public void setPhoneReceiver(String phoneReceiver) {
            this.phoneReceiver = phoneReceiver;
        }

    }

    private class OrderDetailAdapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<OrderDetail> arrayOrderDetail;

        public OrderDetailAdapter(Context context, int layout, List<OrderDetail> orderdetailList) {
            myContext = context;
            myLayout = layout;
            arrayOrderDetail = orderdetailList;
        }

        @Override
        public int getCount() {
            return arrayOrderDetail.size();
        }

        @Override
        public Object getItem(int position) {
            return null;
        }

        @Override
        public long getItemId(int position) {
            return 0;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {
            LayoutInflater inflater = (LayoutInflater) myContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(myLayout, null);

            TextView phone_store = (TextView) convertView.findViewById(R.id.phone_store);
            TextView address_store = (TextView) convertView.findViewById(R.id.address_store);
            TextView bill_of_lading_order_detail = (TextView) convertView.findViewById(R.id.bill_of_lading_order_detail);
            TextView name_product = (TextView) convertView.findViewById(R.id.name_product);
            //TextView number_of_product = (TextView) convertView.findViewById(R.id.number_of_product);

            TextView receiver = (TextView) convertView.findViewById(R.id.receiver);
            TextView phone_receiver = (TextView) convertView.findViewById(R.id.phone_receiver);

            phone_store.setText(arrayOrderDetail.get(position).getPhoneStore());
            address_store.setText(arrayOrderDetail.get(position).getAddressStore());
            bill_of_lading_order_detail.setText(arrayOrderDetail.get(position).getBillOfLading());
            name_product.setText(arrayOrderDetail.get(position).getNameProduct());
            receiver.setText(arrayOrderDetail.get(position).getNameReceiver());
            phone_receiver.setText(arrayOrderDetail.get(position).getPhoneReceiver());
//            dialog.show();
            return convertView;
        }
    }
}