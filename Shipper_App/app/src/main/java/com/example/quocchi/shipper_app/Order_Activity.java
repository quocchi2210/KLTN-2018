package com.example.quocchi.shipper_app;

import android.content.Context;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.List;

public class Order_Activity extends AppCompatActivity {

    private ArrayList<Order> data = new ArrayList<Order>();
    //public int position_index = -1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order);

        ListView lv = findViewById(R.id.list_view);

        data.add(new Order("math","123"));
        data.add(new Order("history","456"));
        data.add(new Order("van hoc","789"));

        lv.setAdapter(new OrderAdapter(this, R.layout.list_item, data));


    }

    private class OrderAdapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<Order> arrayOrder;

        public OrderAdapter(Context context, int layout, List<Order> orderList){
            myContext = context;
            myLayout = layout;
            arrayOrder = orderList;
        }

        @Override
        public int getCount() {
            return arrayOrder.size();
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

            bill_of_lading.setText(data.get(position).getBill_of_lading());
            address.setText(data.get(position).getAddress());

            LinearLayout lnlo_order = (LinearLayout) convertView.findViewById (R.id.lnlo_order);

            final int vitri = position;

            lnlo_order.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Toast.makeText(Order_Activity.this, data.get(vitri).getBill_of_lading(), Toast.LENGTH_LONG).show();
                }
            });

//            list_item_text.setText(data.get(position).getA());
//            Button list_item_btn = (Button) convertView.findViewById(R.id.list_item_btn);
//
//            list_item_btn.setOnClickListener(new View.OnClickListener() {
//                @Override
//                public void onClick(View view) {
//                    Toast.makeText(Order_Activity.this,data.get(vitri).getA(),Toast.LENGTH_SHORT).show();
//                }
//            });

            return convertView;
        }
    }


    private class Order{
        private String bill_of_lading;
        private String address;

        Order(String bill_of_lading, String address){
            this.bill_of_lading = bill_of_lading;
            this.address = address;
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
    }
}
